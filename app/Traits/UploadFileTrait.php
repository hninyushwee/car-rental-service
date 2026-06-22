<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{
    /**
     * စနစ်တကျ File Upload ပြုလုပ်ပေးမည့် Common Method
     *
     * @param UploadedFile $file တင်မည့် File အမျိုးအစား
     * @param string $folder သိမ်းဆည်းလိုသည့် Folder Name (e.g., 'vehicles')
     * @param string $disk သိမ်းမည့်နေရာ (default က 'public' ဖြစ်ပါသည်)
     * @param string|null $oldFile ဖျက်ပစ်ချင်သည့် ဖိုင်အဟောင်းလမ်းကြောင်း (Update လုပ်ချိန်တွင် သုံးရန်)
     * @return string သိမ်းဆည်းလိုက်သော File Path လမ်းကြောင်း
     */
    public function uploadFile(UploadedFile $file, string $folder,string $disk='public', string $oldFile = null ):string
    {
        if($oldFile && Storage::disk($disk)->exists($oldFile)){
            Storage::disk($disk)->delete($oldFile);
        }
        return $file->store($folder, $disk);
    }
    public function deleteFile(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }
}