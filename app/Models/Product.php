<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Image,Storage;
use App\Models\User;
use App\Models\{Order,OrderProduct};
use App\Models\Admin\{ProductCategory,ProductSubCategory,ProductMeta,Rating};
use App\Models\Frontend\{Comments,Wishlist};

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'product_type',
        'name',
        'slug',
        'image',
        'category_id',
        'sub_category_id',
        'user_id',
        'tags',
        'description',
        'quantity',
        'preview_link',
        'uploaded_by',
        'price',
        'is_enable_multi_price',
        'file_type',
        'file_name',
        'file_url',
        'file_open_pass',
        'coupon_id',
        'is_active',
        'is_fee',
        'is_preview',
        'is_featured',
        'meta_title',
        'meta_keywords',
        'meta_desc',
        'sale_count',
        'rating',
        'short_desc',
        'product_details'
    ];

    public function getThumbAttribute()
    {
        if ($this->image != ""){
            $path = str_replace('images','thmbnail',$this->image);
            return Storage::url($path);
        }
        return "";
    }

    public function getImageUrlAttribute()
    {
        if ($this->image != "")
            return Storage::url($this->image);

        return $this->image;
    }

    public function getImageAttribute($path)
    {
        if ($path != "")
            return Storage::url($path);

        return $path;
    }

    public function save(array $options = []){
        if (request()->hasFile("image") && request()->file("image")->isValid()) {
            $image = request()->file('image');
            $imageName = time() . uniqid() . '.' . $image->extension();

            if (str_starts_with($image->getMimeType(), 'image/')) {
                $this->image = $image->storeAs($this->folderPath(), $imageName);

                $img = Image::make($image->path());
                $img->resize(400, 250, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $tempPath = sys_get_temp_dir() . '/' . $imageName;
                $img->save($tempPath);
                Storage::put($this->thumbfolderPath() . '/' . $imageName, file_get_contents($tempPath), 'public');
                unlink($tempPath);
            } elseif (str_starts_with($image->getMimeType(), 'video/')) {
                $this->image = $image->storeAs($this->folderPath(), $imageName);
            } elseif (str_starts_with($image->getMimeType(), 'audio/')) {
                $this->image = $image->storeAs($this->folderPath(), $imageName);
            }
        }
        return parent::save($options);
    }

    public function folderPath()
    {
        return "product/images/" . strtolower(date("FY"));
    }
    public function thumbfolderPath()
    {
        return "product/thmbnail/" . strtolower(date("FY"));
    }
    public function previewfolderPath()
    {
        return "product/preview/" . strtolower(date("FY"));
    }
    public function filefolderPath()
    {
        return "product/files/" . strtolower(date("FY"));
    }

    public function getCategory()
    {
        return $this->hasOne(ProductCategory::class, 'id','category_id');
    }
    public function getUser()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function getProductDetailsAttribute($val)
    {
        return unserialize($val);
    }

    public function scopeFilter($query)
    {
        if (request('product_type'))
            $query->where('product_type', '=', request('product_type'));
        if(request('category_id'))
            $query->where('category_id', '=', request('category_id'));
        if(request('sub_category_id'))
            $query->where('sub_category_id', '=', request('sub_category_id'));
        if (request('filter') == 'contains')
            $query->where(request('key'), 'like', '%' . request('s') . '%');
        if (request('filter') == 'equals')
            $query->where(request('key'), '=', request('s'));
        if (request('filter') == 'greaterEquals')
            $query->where(request('key'), '>=', request('s'));
        if (request('filter') == 'lesserEquals')
            $query->where(request('key'), '<=', request('s'));
        return;
    }

    public function scopeMightAlsoLike($query) {
        return $query->inRandomOrder()->where('is_active',1)->take(3);
    }

    public function getProductReview(){
        return $this->hasMany(Rating::class, 'product_id','id')->whereNull('parent_id');
    }
    public function getProductComment(){
        return $this->hasMany(Comments::class, 'product_id','id')->whereNull('parent_id');
    }

    public function getNetRevenue(){
        return OrderProduct::where('product_id',$this->id)->sum('vendor_amount');
    }

    public function getProductMetaAttribute(){
        return (object) $this->hasOne(ProductMeta::class, 'product_id','id')->pluck('value','key')->toArray();
    }

    public function productPrice(){
        $free= 0; $from = 0; $to = 0; $price = 0; $offer_price = 0;
        if($this->is_free == '1'){
            $free = 1;
            $price =  $this->price;
        }else{
            if (($this->is_enable_multi_price == 1 && isset($this->productMeta->multi_price) &&!empty($this->productMeta->multi_price))){
                $priceArr = (object) unserialize(@$this->productMeta->multi_price);
                foreach ($priceArr as $key => $value){
                    if($key == 0){
                        if (!empty(@$value['offer_price']) && @$this->is_offer != 0){
                            $from = @$value['offer_price'];

                        }
                        else{
                            $from =  @$value['price'];
                        }
                    }else{
                        if (!empty(@$value['offer_price']) && @$this->is_offer != 0){
                            $to = @$value['offer_price'];

                        }
                        else{
                            $to =  @$value['price'];
                        }
                    }
                }
            }
            else{
                if (@$this->is_offer != '0')
                   $offer_price  = $this->offer_price;

                   $price =  $this->price;

            }
        }

        return  ['free' => $free, 'from' => $from, 'to'=> $to, 'price'=>$price,'offer_price'=>$offer_price];
    }

    public function getStatusStrAttribute()
    {
        if($this->status == 1)
            return 'Accept';
        elseif($this->status == 2)
            return 'Review';
        elseif($this->status == 3)
            return 'Reject';
        else
            return 'Pending';
    }

    public function getdownlaodfilelink($variants){
        $data = (object) $this->hasOne(ProductMeta::class, 'product_id','id')->pluck('value','key')->toArray();
        $newFileArr=[];
        $fileArr = unserialize(@$data->multi_file);

        if(!empty($variants)){
            $variants = unserialize($variants);
            foreach ($variants as $key => $v2) {
                foreach ($fileArr as $key => $v3) {
                    if($v3['file_price'] == @$v2['price_id'] || $v3['file_price'] == "ALL"){
                        $v3['product_id'] = base64url_encode($this->id);
                        unset($v3['file_external_url']);
                        unset($v3['file_url']);
                        $newFileArr[] = $v3;
                    }
                }
            }
        }else{
            foreach ($fileArr as $key => $v3) {
                $v3['product_id'] =  base64url_encode($this->id);
                unset($v3['file_external_url']);
                unset($v3['file_url']);
                $newFileArr[] = $v3;
            }
        }
        return $newFileArr;
    }

    public function getUserProductReview(){
        return $this->hasOne(Rating::class, 'product_id','id')->where('user_id',auth()->id());
    }

    public function ratingUpdate($id)
    {
        return  Rating::where('product_id',4)->avg('rating');
    }

    public function check_in_wishlist(){
        return $this->hasOne(Wishlist::class, 'product_id','id')->where('user_id',auth()->id())->exists();
    }
}
