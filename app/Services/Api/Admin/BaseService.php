<?php


namespace App\Services\Api\Admin;


use App\Models\Direction;
use App\Models\Exam;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BaseService
{
    /**
     * @var
     */
    protected $baseModel;

    /**
     * @var
     */
    public $findColumns = [];

    /**
     * @param $model
     */
    protected function set_model($model)
    {
        $this->baseModel = $model->query();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return $this->baseModel->create($data);
    }


    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        if (empty($this->findColumns)) {
            $this->findColumns = $this->baseModel->getModel()->getFillable();
            $this->findColumns[] = "id";
        }

        $item = $this->baseModel->find($id, $this->findColumns);

        if (!$item) {
            return false;
        }
        if (!$item->update($data)){
            return false;
        }
        return $item;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $deleteItem = $this->baseModel->find($id);
        if (!$deleteItem) {
            return false;
        }
        $deleted = $deleteItem->delete();
        return $deleted;
    }

    /**
     * @param $data
     * @param null $name
     * @return array|mixed
     */

    public function getDataImage($data, $imageNameForData, $blockName = "section", $name = null)
    {
        $image = $data[$imageNameForData];
        $dataImage = [];

        if (!empty($image)) {
            $pathname = strtoupper($blockName)."ImgPath";
            $path = storage_path($pathname::IMAGE_URL);
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $w = config('app_settings.'.$blockName.'_img_width');
            $h = config('app_settings.'.$blockName.'_img_height');

            $dataImage = $this->upload($image, $path, '', $w, '', $h, '', $name);
        }
        return $dataImage;
    }

    /**
     * @param $file
     * @param $path
     * @param $path1
     * @param $width
     * @param $width1
     * @param $height
     * @param $height1
     * @param null $fileName
     * @return mixed
     */
    public function upload($file, $path, $path1, $width, $width1, $height, $height1, $fileName = null)
    {

        $extension = $file->getClientOriginalExtension();

        if ($fileName) {
            $fileName .= '.' . $extension;
        } else {
//            $fileName = md5(str_random(20)) . '.' . $extension;
            $fileName = md5(microtime(true)) . '.' . $extension;
        }

        // File save
        $originalFile = Image::make($file->getRealPath());
        $result = $originalFile
            ->resize($width, $height, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })
            ->save($path . $fileName);
        if (!empty($path1)) {
            $result1 = $originalFile
                ->resize($width1, $height1, function ($q) {
                    $q->aspectRatio();
                    $q->upsize();
                })
                ->save($path1 . $fileName);

            $if = (bool)$result && isset($result1);
        } else {
            $if = (bool)$result;
        }
        if ($if) {
            //$data['size'] = filesize($file);
            $data['file_name'] = $fileName;
            return $data;
        }
    }

}
