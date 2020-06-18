<?php


namespace App\Services\Api\Admin;


use App\Models\Passage;

class PassageService extends BaseService
{

    /**
     * PassageService constructor.
     * @param Passage $passage
     */
    public function __construct(Passage $passage)
    {
        $this->set_model($passage);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $dataImage = $this->getDataImage($data, 'img_url', 'passage');
        if (!empty($dataImage)) {
            $data['img_url'] = $dataImage['file_name'];
        }
        return parent::store($data);
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        $dataImage = $this->getDataImage($data, 'img_url', 'passage');
        if (!empty($dataImage)) {
            $data['img_url'] = $dataImage['file_name'];
        }
        return parent::update($id, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->baseModel->with('questions:id,passage_id,question')->find($id, ['id', 'title']);
    }
}
