<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Setting::create([
            "app_name" => "Trisoline Global Company LTD",
            "app_logo" => "logo.png",
            "phone_number" => "+96415241357",
            "address" => "ZheJiang Province Ningbo City Beilun District Miaoqianshan Road145",
            "contact_email" => "support@trisoline.com",
            "facebook_link" => "https://www.facebook.com/trisoline",
            "youtube_link" => "",
            "instagram_link" => "https://instagram.com/trisoline_global",
            "linkedin_link" => "https://x.com/TrisolineGlobal",
            "twitter_link" => "",
            "intro_text" =>"We ensure our clients orders from China with the best prices available with the highest quality available as well. Also We specialize in real estate marketing in Turkey and provide the service that investors deserve.",
            "intro_text_ar" =>"نحن نضمن لعملائنا طلبيات من الصين بأفضل الأسعار المتاحة بأعلى جودة متاحة أيضًا. كما أننا متخصصون في التسويق العقاري في تركيا وتقديم الخدمة التي يحتاجها المستثمرون.",
            "whatsapp_number" =>"+96415241357",
            "video_section_link" =>"",
            "about_text"  =>"Trisoline is a platform for global trade and real estate investments. Its services in the Chinese branch include everything related to providing, manufacturing, researching and processing all types of 
            goods and merchandise from China at factory prices to all countries at the best prices and best services. The Turkish branch specializes in real estate investments by providing the best existing residential projects 
            and managing its clients’ investments. Real estate in Turkey. We also provide all types of legal support to facilitate legal procedures for investment and living in Turkey.",
            "about_text_ar"  =>"تشتغل Trisoline في التجارة العالمية وكدا الاستثمارات العقارية. ولديها فرعين: الفرع الصيني وتشمل خدماته كل ما يتعلق بتوفير،تصنيع، بحث وتجهيز جميع أنواع البضائع من الصين بأسعار المصنع إلى جميع الدول وبأفضل الأسعار المتاحة
             بحيث تكون كل الخطوات مسجلة في النظام الالكتروني للشركة لكي يطلع عليها العميل باستمرار.
             ويتخصص الفرع التركي في الاستثمارات العقارية من خلال تقديم أفضل المشاريع 
            السكنية القائمة وإدارة استثمارات عملائه. . كما يقدم كافة أنواع الدعم القانوني لتسهيل الإجراءات القانونية للاستثمار والعيش في تركيا.
معرض الأعمال",
            "vision_text"  =>"To be a leader in the field of global trade and to provide the best service to our customers without the need to move and travel to and from China and Turkey.",
            "vision_text_ar"  =>"ن نكون شركة رائدة في مجال التجارة العالمية وتقديم أفضل الخدمات لعملائنا دون الحاجة إلى التنقل والسفر من وإلى الصين وتركيا.",
            "goals_text"  =>"Helping people or organizations to launch or expand their business and Providing our customer’s requirements with the best required quality and the lowest possible price.",
            "goals_text_ar"  =>"مساعدة الأشخاص أو المؤسسات على إطلاق أعمالهم أو توسيعها وتوفير متطلبات عملائنا بأفضل جودة مطلوبة وأقل سعر ممكن",
            "values_text"  =>"Customer first + We pay special attention to achieving customer satisfaction. We have a team of professionals with high experience in international trade and managing import and export operations and they will be able to provide the best quality of work.",
            "values_text_ar"  =>"العميل أولا + نحن نولي اهتماما خاصا لتحقيق رضا العملاء. لدينا فريق من المحترفين ذوي الخبرة العالية في التجارة الدولية وإدارة عمليات الاستيراد والتصدير وسيكونون قادرين على تقديم أفضل جودة للعمل."
        ]);
    }
}
