<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'background_path',
        'name_x', 'name_y', 'name_font_size', 'name_color',
        'course_x', 'course_y', 'course_font_size', 'course_color',
        'date_x', 'date_y', 'date_font_size', 'date_color',
        'cert_number_x', 'cert_number_y', 'cert_number_font_size', 'cert_number_color',
        'qr_x', 'qr_y', 'qr_size',
        'is_active',
    ];
}
