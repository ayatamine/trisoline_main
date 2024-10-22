<?php

use App\Livewire\QuotaForm;
use App\Mail\ContactMessage;
use App\Models\Step;
use App\Models\User;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Firefly\FilamentBlog;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $services =$steps=$locale = null;
    if(app()->getLocale() == "ar")
    {
        $locale_extension = '_ar'; ;
    }
    else{
       $locale_extension = '';
    }
    $settings = Setting::select( 'app_name',
        'app_logo',
        'phone_number',
        'turkey_phone_number',
        'address',
        'contact_email',
        'facebook_link',
        'youtube_link',
        'instagram_link',
        'linkedin_link',
        'twitter_link',
        'intro_text'.$locale_extension,
        'intro_sliding_words'.$locale_extension,
        'whatsapp_number',
        'video_section_link',
        'about_text'.$locale_extension,
        'vision_text'.$locale_extension,
        'goals_text'.$locale_extension,
        'values_text'.$locale_extension,
        'default_lang',
        'show_projects_section',
        'show_testimonials_section',
        'show_blog_section',
        'meta_title',
        'meta_image',
        'favicon',
        'meta_description',
        'meta_keywords'
        )->first()->toArray();
    $services = Service::select("title$locale_extension","description$locale_extension",'image')->get()->toArray();
    $steps = Step::select("title$locale_extension","description$locale_extension",'image')->orderBy('step_order','asc')->get()->toArray();
    $testimonials = Testimonial::get();
    $blogs =User::first()->posts;
    $projects =Project::with('types')->take(6)->get()->toArray();
    // dd(implode(', ',$settings["intro_sliding_words$locale_extension"]));
    $text_type_effect =  '"",';
    foreach ($settings["intro_sliding_words$locale_extension"] as $key => $value) {
        if($key !=  count($settings["intro_sliding_words$locale_extension"]) -1)
        {
             $text_type_effect .= '"'.$value.'",';
        }
        else{$text_type_effect .= '"'.$value.'"';}
    }
    
    return view('home',compact('settings','services','steps','testimonials','locale_extension','blogs','projects',"text_type_effect"));
})->name('home');
Route::get('language/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
 
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('change_locale'); 
Route::post('contact/send', function (Request $request) {
    $validated = $request->validate([
        'name'=>'string|required|max:80',
        'email'=>'email|required',
        'subject'=>'string|required|max:200',
        'message'=>'string|required|max:300',
    ]);
    
    try {
        //create contact
        $message =Contact::create($validated);
        //send email
        Mail::to(Setting::first()->contact_email, Setting::first()->app_name)->send(new ContactMessage($message));
        session()->flash('success','تم ارسال الرسالة بنجاح وستم الرد عليك في أقرب  فرصة');
    } catch (\Throwable $th) {
       session()->flash('error','حدث خطأ أثناء الارسال يرجى المحاولة لاحقا');
    }
    
    return redirect('/#contact');
})->name('send_contact');
Route::get('/quota/new',function()
{
    $settings = Setting::select( 'app_name',
    'app_logo',
    'phone_number',
    'turkey_phone_number',
    'address',
    'contact_email',
    'facebook_link',
    'youtube_link',
    'instagram_link',
    'linkedin_link',
    'twitter_link',
    'default_lang',
    'meta_title',
    'meta_image',
    'favicon',
    'meta_description',
    'meta_keywords'
    )->first()->toArray();
    return view('add_quota',compact('settings'));
})->name('create_quota');
Route::get('/quotation-terms-conditions',function(){

    return view('quotation_contract_conditions');

})->name('quotation_terms');
