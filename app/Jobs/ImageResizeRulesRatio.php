<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Storage;
use Image;

class ImageResizeRulesRatio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $width;
    protected $height;
    protected $image_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($width , $height , $image_path)
    {
        $this->width        = $width;
        $this->height       = $height;
        $this->image_path   = $image_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Image::make(Storage::disk('public')->path($this->image_path))
                ->widen($this->width)
                ->resizeCanvas($this->width, $this->height)
                ->save(Storage::disk('public')->path($this->image_path))
                ->destroy();
    }
}
