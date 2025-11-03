<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StorageLinkController extends Controller
{
    public function createLink()
    {
        $publicPath  = base_path('../public'); // যদি public ফোল্ডার dev-এর বাইরে থাকে
        $target      = storage_path('app/public');
        $link        = $publicPath . '/storage';

        // Check if target exists
        if (!is_dir($target)) {
            return response()->json(['status' => 'error', 'message' => "Target folder does not exist: $target"], 500);
        }

        // Remove existing link if it’s already a symlink
        if (file_exists($link)) {
            if (is_link($link)) {
                unlink($link);
            } else {
                return response()->json(['status' => 'error', 'message' => "Link already exists and is not a symlink: $link"], 500);
            }
        }

        // Create symbolic link
        if (symlink($target, $link)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Symlink created successfully.',
                'target' => $target,
                'link' => $link,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create symbolic link.',
            ], 500);
        }
    }
}
