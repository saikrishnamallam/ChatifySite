// app/Models/PdfFile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdfFile extends Model
{
    // Define the table associated with this model
    protected $table = 'pdf_files';

    // Define the fillable fields that can be mass-assigned
    protected $fillable = ['name', 'path'];

    // Optionally, define any relationships or custom methods relevant to this model
    // For example:
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
