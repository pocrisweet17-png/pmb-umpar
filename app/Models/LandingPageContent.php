<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPageContent extends Model
{
    use HasFactory;

    protected $fillable = ['section', 'key', 'value', 'type'];

    /**
     * Get content by section and key
     */
    public static function getContent($section, $key, $default = '')
    {
        $content = self::where('section', $section)
                      ->where('key', $key)
                      ->first();
        
        return $content ? $content->value : $default;
    }

    /**
     * Set content
     */
    public static function setContent($section, $key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['section' => $section, 'key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Get all content by section
     */
    public static function getSection($section)
    {
        return self::where('section', $section)->get()->pluck('value', 'key');
    }
}