<?php

namespace App\Repositories\Contracts;

interface BibleRepositoryInterface
{
   public function getVersions();
   public function getBooks($version);
   public function getChapters($version, $book);
   public function getVerses($version, $book, $chapter);
}