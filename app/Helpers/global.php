<?php

use Hashids\Hashids;
use Illuminate\Support\Facades\File;

function encode($id, $connection = 'main')
{
    $config = config('hashids.connections.' . $connection);
    return (new Hashids($config['salt'], $config['length'], $config['alphabet']))->encode($id);
}

function decode($hash, $connection = 'main')
{
    $config = config('hashids.connections.' . $connection);
    $decode = (new Hashids($config['salt'], $config['length'], $config['alphabet']))->decode($hash);
    if (count($decode) > 0) return $decode[0];
    return null;
}

function pager()
{
    $req = request();
    $page = $req->get('page', 1);
    $limit = $req->get('limit', 10);
    $offset = ($page - 1) * $limit;
    return [
        'offset' => $offset,
        'limit' => $limit,
        'page' => $page,
    ];
}


function saveFile($file, $folder) {
    $extension = $file->getClientOriginalExtension(); // getting image extension
    $filename = time().'.'.$extension;
    $path = 'uploads/'.$folder.'/'.$filename;
    $file->move('uploads/'.$folder.'/', $filename);
    return $path;
}

function deleteFile($path) {
    File::delete($path);
}