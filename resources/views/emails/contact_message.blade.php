

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <link rel="stylesheet" href="{{asset('assets/css/tailwind.css')}}">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
        <style>
            *{
                   font-family: "Noto Kufi Arabic", sans-serif !important;
                   font-optical-sizing: auto;
                   font-style: normal;
           }
        </style>
    </head>
    <body dir="rtl"  style="text-align: right">
        
        <div>
            رسالة تواصل جديدة على trisoline الرئيسي
            <br><br>
            <span>الاسم</span> <strong style="margin:0 2px;">{{$message->name}}</strong><br><br>
            <span>البريد الالكتروني </span> <strong style="margin:0 2px;">{{$message->email}}</strong><br><br>
            <span>الموضوع</span> <strong style="margin:0 2px;">{{$message->subject}}</strong><br><br>
            <span>نص الرسالة</span> <strong style="margin:0 2px;">{{$message->message}}</strong><br><br>
        </div>

        <x-mail::button :url="$contact_url">
        الانتقال للرسائل
        </x-mail::button>
        شكرا لك,<br>
        {{ \App\Models\Setting::first()->app_name}}
 </body>
</html>


