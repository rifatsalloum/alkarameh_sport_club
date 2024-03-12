<?php
function message($message = null,$crud = 8,$object_message = null){
    if($message)
     return $message;

    if($object_message)
     return $object_message;

    $messages = ["تم التحديث","لم يتم التحديث",
                 "تم الادخال","لم يتم الادخال",
                 "تم تسجيل الدخول","خطأ في تسجيل الدخول",
                 "تم تسجيل الخروج","خطأ في تسجيل الخروج",
                ];
    
     return ($crud < count($messages))? $messages[$crud] : "لايوجد بيانات";
    
}