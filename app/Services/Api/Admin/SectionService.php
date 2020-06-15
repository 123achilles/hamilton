<?php


namespace App\Services\Api\Admin;


use App\Models\Direction;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        $section = parent::store($data->except('directions'));
        if (!$section){
            return false;
        }

        $dat = $data->only('directions');
        foreach ($dat['directions'] as $i){
            $d[] = new Direction($i);
        }
        $directions = $section->directions()->saveMany($d);

        if (!$directions){
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
    {$data['exam_id'] = 1;
        DB::beginTransaction();
        $section = parent::update($id, $data->except('directions'));
        if (!$section){
            DB::rollBack();
            return false;
        }

        $dat = $data->only('directions');
        foreach ($dat['directions'] as $k => $i){
            $d[$k] = $i;
            $d[$k]['section_id'] = $id;
        }

        if (!$section->directions()->delete()){
            DB::rollBack();
            return false;
        }
        if (!$section->directions()->insert($d)){
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
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
