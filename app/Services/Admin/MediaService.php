<?php

namespace App\Services\Admin;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;

class MediaService
{
    public function handleUploads(HasMedia $item, array $files): void
    {
        $this->hasMediaSupport($item);

        if (isset($files['image'])) {
            $this->validateFile($files['image']);
            $this->clearMedia($item);
            $this->addMedia($item, $files['image']);
        }

        if (isset($files['document'])) {
            $this->validateFile($files['document']);
            $this->clearMedia($item, 'document');
            $this->addMedia($item, $files['document'], 'document');
        }

        if (isset($files['documents'])) {
            foreach ($files['documents'] as $document) {
                $this->validateFile($document);
                $this->addMedia($item, $document, 'documents');
            }
        }

        if (isset($files['gallery'])) {
            $gallery = is_array($files['gallery']) ? $files['gallery'] : [$files['gallery']];
            foreach ($gallery as $image) {
                $this->validateFile($image);
                $this->addMedia($item, $image, 'gallery');
            }
        }
    }

    public function addMedia(HasMedia $item, UploadedFile $file, string $collection = 'default'): void
    {
        $this->hasMediaSupport($item);

        $fileName = $this->generateFileName($file);

        try {
            $item->addMedia($file)->usingFileName($fileName)->toMediaCollection($collection);
        } catch (Exception $e) {
            throw new Exception('Beklenmedik Bir Hata Meydana Geldi');
        }
    }

    public function clearMedia(HasMedia $item, string $collection = 'default'): void
    {
        $this->hasMediaSupport($item);

        try {
            $item->clearMediaCollection($collection);
        } catch (Exception $e) {
            throw new Exception('Beklenmedik Bir Hata Meydana Geldi');
        }
    }

    private function validateFile($file): void
    {
        if (!$file instanceof UploadedFile) {
            throw new Exception('Geçersiz dosya türü');
        }

        if (!$file->isValid()) {
            throw new Exception('Dosya doğrulanamadı: ' . $file->getErrorMessage());
        }
    }

    private function generateFileName(UploadedFile $file): string
    {
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);
        $extension = $file->extension();

        return "{$timestamp}_{$random}.{$extension}";
    }

    private function hasMediaSupport($item): void
    {
        if (!$item instanceof HasMedia) {
            throw new Exception('Model medya desteğine sahip değil.');
        }
    }
}
