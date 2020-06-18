<?php


namespace App\Services\Api\Admin;


use App\Models\Direction;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\This;

class SectionService extends BaseService
{

    /**
     * SectionService constructor.
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->set_model($section);
    }


    /**
     * @param $data
     * @return bool|mixed
     */
    public function store($data)
    {
        [$data, $dat] = $this->changeData($data);

        $section = parent::store($data);
        if (!$section) {
            return false;
        }

        foreach ($dat as $i) {
            if (!empty($i['direction_img'])) {
                $imageName = $this->getDataImage($i, 'direction_img');
                $i['direction_img'] = $imageName['file_name'];
            }
            $d[] = new Direction($i);
        }
        $directions = $section->directions()->saveMany($d);

        if (!$directions) {
            return false;
        }
        return $section;
    }


    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        [$data, $dat] = $this->changeData($data);

        DB::beginTransaction();
        $section = parent::update($id, $data);
        if (!$section) {
            DB::rollBack();
            return false;
        }

        foreach ($dat as $k => $i) {

            if (!empty($i['direction_img'])) {
                $imageName = $this->getDataImage($i, 'direction_img');
                $i['direction_img'] = $imageName['file_name'];
            } else {
                $i['direction_img'] = null;
            }
            $d[$k] = $i;
            $d[$k]['section_id'] = $id;
        }

        if (!$section->directions()->delete()) {
            DB::rollBack();
            return false;
        }
        if (!$section->directions()->insert($d)) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * @param $data
     * @return array
     */
    public function changeData($data)
    {
        $dataImage = $this->getDataImage($data, 'reference_img');
        if (!empty($dataImage)) {
            $data['reference_img'] = $dataImage['file_name'];
        }
        $dat = $data['directions'];
        unset($data['directions']);

        return [$data, $dat];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->baseModel->with('passages:id,section_id,title','directions:id,section_id')->find($id, ['id', 'title']);
    }



//    /**
//     * @param $id
//     * @return int
//     */
//    public function delete($id)
//    {
//        return Section::destroy($id);
//    }
}
