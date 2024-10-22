@extends('components.layouts.client')
@section('content')
    <style>
        p{
            line-height: 2.2;
            font-size: 1.2rem;
            margin: 1rem 0;
        }
        h2{
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 4rem;
        }
    </style>
    <div  class="container px-0 py-36 md:h-screen h-auto items-center block bg-gray-900 bg-center bg-cover active">
        @if(app()->getLocale() == "en")
        <div class="bg-white shadow-md p-10 rounded" style="padding:5rem">
            <h2>Terms and Conditions for Quotation Requests</h2>
        
            <p><strong>1. Accuracy of Information</strong><br>
            By submitting the form, you confirm that all information provided is accurate and complete to the best of your knowledge. Any inaccuracies may affect the quotation provided.</p>
        
            <p><strong>2. Non-Binding Estimate</strong><br>
            The quotation you receive is based on the information provided and is a non-binding estimate. Final pricing may vary depending on factors such as availability, unforeseen costs, and additional requirements discussed during the final agreement.</p>
        
            <p><strong>3. Confidentiality</strong><br>
            All information shared through the form will be treated with strict confidentiality in line with our <a href="https://china.trisoline.com/privacypolicy">Privacy Policy</a>. We will not disclose your details to any third party without your consent.</p>
        
            <p><strong>4. Quotation Validity</strong><br>
            Unless otherwise specified, quotations provided are valid for [insert validity period, e.g., 30 days]. After this period, prices and availability may change without notice.</p>
        
            <p><strong>5. Changes to the Quotation</strong><br>
            Any changes to the scope of the request after the submission of this form may result in an adjusted quotation. We will communicate any revisions before finalizing the agreement.</p>
        
            <p><strong>6. Acceptance of Terms</strong><br>
            By submitting a request for a quotation, you agree to these terms and conditions. Acceptance of the final quotation is required before any work or services are initiated.</p>
        
            <p><strong>7. Dispute Resolution</strong><br>
            Any disputes arising from the quotation or subsequent agreements will be handled in accordance with the governing laws of China / Turkey / Saudi Arabic.</p>
        </div>
        @else 
        <div>
            <h2>الشروط والأحكام لطلبات عرض الأسعار</h2>
        
            <p><strong>1. دقة المعلومات</strong><br>
            من خلال تقديم النموذج، فإنك تؤكد أن جميع المعلومات المقدمة دقيقة وكاملة حسب معرفتك. أي أخطاء قد تؤثر على عرض السعر المقدم.</p>
        
            <p><strong>2. عرض السعر غير الملزم</strong><br>
            يعتمد عرض السعر الذي تتلقاه على المعلومات المقدمة وهو عرض تقديري غير ملزم. قد يختلف السعر النهائي بناءً على عوامل مثل التوافر والتكاليف غير المتوقعة والمتطلبات الإضافية التي تتم مناقشتها خلال الاتفاق النهائي.</p>
        
            <p><strong>3. السرية</strong><br>
            سيتم التعامل مع جميع المعلومات التي تمت مشاركتها من خلال النموذج بسرية تامة وفقًا لـ <a href="https://china.trisoline.com/privacypolicy">سياسة الخصوصية</a> الخاصة بنا. لن نقوم بالكشف عن تفاصيلك لأي طرف ثالث دون موافقتك.</p>
        
            <p><strong>4. صلاحية عرض السعر</strong><br>
            ما لم يُذكر خلاف ذلك، فإن عروض الأسعار المقدمة تكون صالحة لمدة [أدخل فترة الصلاحية، على سبيل المثال، 30 يومًا]. بعد هذه الفترة، قد تتغير الأسعار والتوافر دون إشعار مسبق.</p>
        
            <p><strong>5. التغييرات في عرض السعر</strong><br>
            أي تغييرات في نطاق الطلب بعد تقديم هذا النموذج قد تؤدي إلى تعديل عرض السعر. سنقوم بالتواصل معك بشأن أي تعديلات قبل إتمام الاتفاق.</p>
        
            <p><strong>6. قبول الشروط</strong><br>
            من خلال تقديم طلب للحصول على عرض السعر، فإنك توافق على هذه الشروط والأحكام. يتطلب قبول عرض السعر النهائي قبل بدء أي عمل أو خدمات.</p>
        
            <p><strong>7. تسوية النزاعات</strong><br>
            سيتم التعامل مع أي نزاعات تنشأ عن عرض السعر أو الاتفاقات اللاحقة وفقًا لقوانين [أدخل الولاية القضائية أو الدولة].</p>
        </div>
        @endif
    </div>
@endsection