<?php

namespace App\Jobs;

use App\Models\Choice;
use App\Models\Direction;
use App\Models\Passage;
use App\Models\Question;
use App\Models\Section;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class deleteImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        delete section images
        $sectionPath = storage_path(\SectionImgPath::IMAGE_URL);
        $sectionfiles = File::allFiles($sectionPath);
        $dirImages = Direction::all(['direction_img'])->pluck('direction_img');
        $refImages = Section::all(['reference_img'])->pluck('reference_img');
        $images = array_merge($dirImages->toArray(), $refImages->toArray());
        $this->deleteImages($sectionfiles, $images, $sectionPath);
//          delete passage images
        $passagePath = storage_path(\PassageImgPath::IMAGE_URL);
        $passageFiles = File::allFiles($passagePath);
        $passImages = Passage::all(['img_url'])->pluck('img_url')->toArray();
        $this->deleteImages($passageFiles, $passImages, $passagePath);
//          delete question images
        $questionPath = storage_path(\QuestionImgPath::IMAGE_URL);
        $questionfiles = File::allFiles($questionPath);
        $questImages = Question::all(['question_img'])->pluck('question_img');
        $choiceImages = Choice::all(['choice_img'])->pluck('choice_img');
        $imagesQuestion = array_merge($questImages->toArray(), $choiceImages->toArray());
        $this->deleteImages($questionfiles, $imagesQuestion, $questionPath);
    }

    /**
     * @param $allFilesThisPath
     * @param $allFilesThisBlock
     * @param $path
     */
    public function deleteImages($allFilesThisPath, $allFilesThisBlock, $path)
    {
        foreach ($allFilesThisPath as $file) {
            if (array_search($file->getFilename(), $allFilesThisBlock) === false) {
                if (!File::delete($path . $file->getFilename())) {
                    Log::error('file not deleted', ['filename' => $file->getFilename(), 'path' => $path]);
                }

            }
        }
    }
}
