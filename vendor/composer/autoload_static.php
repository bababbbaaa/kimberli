<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e1ebd80bf262b86e8cece8ac2ff8bd0
{
    public static $prefixLengthsPsr4 = array (
        'r' => 
        array (
            'rest\\' => 5,
        ),
        'c' => 
        array (
            'cron\\' => 5,
        ),
        'X' => 
        array (
            'XBase\\' => 6,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'K' => 
        array (
            'KB\\' => 3,
        ),
        'I' => 
        array (
            'Inok\\Dbf\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'rest\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
        'cron\\' => 
        array (
            0 => __DIR__ . '/../..' . '/cron',
        ),
        'XBase\\' => 
        array (
            0 => __DIR__ . '/..' . '/hisamu/php-xbase/src/XBase',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'KB\\' => 
        array (
            0 => __DIR__ . '/../..' . '/rest_file',
        ),
        'Inok\\Dbf\\' => 
        array (
            0 => __DIR__ . '/..' . '/inok/dbf/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'G' => 
        array (
            'Gregwar\\Image' => 
            array (
                0 => __DIR__ . '/..' . '/gregwar/image',
            ),
            'Gregwar\\Cache' => 
            array (
                0 => __DIR__ . '/..' . '/gregwar/cache',
            ),
        ),
        'D' => 
        array (
            'Detection' => 
            array (
                0 => __DIR__ . '/..' . '/mobiledetect/mobiledetectlib/namespaced',
            ),
        ),
    );

    public static $classMap = array (
        'Bitrix24\\Access' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/access.php',
        'Bitrix24\\App\\App' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/app/app.php',
        'Bitrix24\\Application\\Application' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/bitrix24application.php',
        'Bitrix24\\Bitrix24' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/bitrix24.php',
        'Bitrix24\\Bitrix24Entity' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/bitrix24entity.php',
        'Bitrix24\\Bizproc\\Activity' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/bizproc/Activity.php',
        'Bitrix24\\Bizproc\\Provider' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/bizproc/Provider.php',
        'Bitrix24\\Bizproc\\Robot' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/bizproc/Robot.php',
        'Bitrix24\\CRM\\Activity' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/activity/activity.php',
        'Bitrix24\\CRM\\Activity\\Communication' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/activity/communication.php',
        'Bitrix24\\CRM\\Additional\\Duplicate' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/additional/duplicate.php',
        'Bitrix24\\CRM\\Company' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/company/company.php',
        'Bitrix24\\CRM\\Company\\UserField' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/company/userfield.php',
        'Bitrix24\\CRM\\Contact' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/contact/contact.php',
        'Bitrix24\\CRM\\Contact\\UserField' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/contact/userfield.php',
        'Bitrix24\\CRM\\Deal\\Category' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/deal/category.php',
        'Bitrix24\\CRM\\Deal\\Deal' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/deal/deal.php',
        'Bitrix24\\CRM\\Deal\\ProductRows' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/deal/productrows.php',
        'Bitrix24\\CRM\\Deal\\UserField' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/deal/userfield.php',
        'Bitrix24\\CRM\\Enum' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/enum/enum.php',
        'Bitrix24\\CRM\\Invoice' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/invoice/invoice.php',
        'Bitrix24\\CRM\\Invoice\\PaySystem' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/invoice/paysystem.php',
        'Bitrix24\\CRM\\Invoice\\PersonType' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/invoice/persontype.php',
        'Bitrix24\\CRM\\Invoice\\Status' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/invoice/status.php',
        'Bitrix24\\CRM\\Invoice\\UserField' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/invoice/userfield.php',
        'Bitrix24\\CRM\\Lead' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/lead/lead.php',
        'Bitrix24\\CRM\\Lead\\ProductRows' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/lead/productrows.php',
        'Bitrix24\\CRM\\Lead\\UserField' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/lead/userfield.php',
        'Bitrix24\\CRM\\LiveFeedMessage\\LiveFeedMessage' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/livefeedmessage/livefeedmessage.php',
        'Bitrix24\\CRM\\Product' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/product/product.php',
        'Bitrix24\\CRM\\ProductRow' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/productrow/productrow.php',
        'Bitrix24\\CRM\\ProductSection' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/productsection/productsection.php',
        'Bitrix24\\CRM\\Product\\Property' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/product/property.php',
        'Bitrix24\\CRM\\Quote' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/quote/quote.php',
        'Bitrix24\\CRM\\Requisite\\Address' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/requisite/address.php',
        'Bitrix24\\CRM\\Requisite\\Bank' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/requisite/bank.php',
        'Bitrix24\\CRM\\Requisite\\Link' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/requisite/link.php',
        'Bitrix24\\CRM\\Requisite\\Preset' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/requisite/preset.php',
        'Bitrix24\\CRM\\Requisite\\PresetField' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/requisite/presetfield.php',
        'Bitrix24\\CRM\\Requisite\\Requisite' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/requisite/requisite.php',
        'Bitrix24\\CRM\\Requisite\\UserField' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/requisite/userfield.php',
        'Bitrix24\\CRM\\Status' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/crm/status/status.php',
        'Bitrix24\\Contracts\\iBitrix24' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/contracts/ibitrix24.php',
        'Bitrix24\\Departments\\Department' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/departments/department.php',
        'Bitrix24\\Entity\\Entity' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/entity/entity.php',
        'Bitrix24\\Event\\Event' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/event/event.php',
        'Bitrix24\\Event\\Util' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/event/util.php',
        'Bitrix24\\Exceptions\\Bitrix24ApiException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24apiexception.php',
        'Bitrix24\\Exceptions\\Bitrix24BadGatewayException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24badgatewayexception.php',
        'Bitrix24\\Exceptions\\Bitrix24EmptyResponseException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24emptyresponseexception.php',
        'Bitrix24\\Exceptions\\Bitrix24Exception' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24exception.php',
        'Bitrix24\\Exceptions\\Bitrix24InsufficientScope' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24insufficientscope.php',
        'Bitrix24\\Exceptions\\Bitrix24IoException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24ioexception.php',
        'Bitrix24\\Exceptions\\Bitrix24MethodNotFoundException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24methodnotfoundexception.php',
        'Bitrix24\\Exceptions\\Bitrix24PaymentRequiredException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24paymentrequiredexception.php',
        'Bitrix24\\Exceptions\\Bitrix24PortalDeletedException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24portaldeletedexception.php',
        'Bitrix24\\Exceptions\\Bitrix24PortalRenamedException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24portalrenamedexception.php',
        'Bitrix24\\Exceptions\\Bitrix24SecurityException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24securityexception.php',
        'Bitrix24\\Exceptions\\Bitrix24TokenIsExpiredException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24tokenisexpiredexception.php',
        'Bitrix24\\Exceptions\\Bitrix24TokenIsInvalidException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24tokenisinvalidexception.php',
        'Bitrix24\\Exceptions\\Bitrix24WrongClientException' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/exceptions/bitrix24wrongclientexception.php',
        'Bitrix24\\FaceTracker\\Client' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/facetracker/client.php',
        'Bitrix24\\FaceTracker\\User' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/facetracker/user.php',
        'Bitrix24\\Im\\Attach\\Attach' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/attach.php',
        'Bitrix24\\Im\\Attach\\Item\\Delimiter' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/item/delimiter.php',
        'Bitrix24\\Im\\Attach\\Item\\File' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/item/file.php',
        'Bitrix24\\Im\\Attach\\Item\\Grid' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/item/grid.php',
        'Bitrix24\\Im\\Attach\\Item\\Image' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/item/image.php',
        'Bitrix24\\Im\\Attach\\Item\\Link' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/item/link.php',
        'Bitrix24\\Im\\Attach\\Item\\Message' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/item/message.php',
        'Bitrix24\\Im\\Attach\\Item\\User' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/item/user.php',
        'Bitrix24\\Im\\Attach\\iAttach' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/iattach.php',
        'Bitrix24\\Im\\Attach\\iAttachItem' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/attach/iattachitem.php',
        'Bitrix24\\Im\\Chat' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/chat.php',
        'Bitrix24\\Im\\Im' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/im.php',
        'Bitrix24\\Im\\Notify' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/im/notify.php',
        'Bitrix24\\Log\\BlogPost' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/log/blogpost.php',
        'Bitrix24\\Placement\\Placement' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/placement/Placement.php',
        'Bitrix24\\Presets\\App\\App' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/app/app.php',
        'Bitrix24\\Presets\\CRM\\Additional\\Duplicate\\EntityTypes' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/additional/entitytypes.php',
        'Bitrix24\\Presets\\CRM\\Additional\\Duplicate\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/additional/fields.php',
        'Bitrix24\\Presets\\CRM\\Company\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/company/fields.php',
        'Bitrix24\\Presets\\CRM\\Contact\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/contact/fields.php',
        'Bitrix24\\Presets\\CRM\\Deal\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/deal/fields.php',
        'Bitrix24\\Presets\\CRM\\Invoice\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/invoice/fields.php',
        'Bitrix24\\Presets\\CRM\\Lead\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/lead/fields.php',
        'Bitrix24\\Presets\\CRM\\Lead\\UserField\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/lead/userfield/fields.php',
        'Bitrix24\\Presets\\CRM\\Products\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/product/fields.php',
        'Bitrix24\\Presets\\CRM\\Products\\ProductRowFields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/crm/product/ProductRowFields.php',
        'Bitrix24\\Presets\\Departments\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/departments/fields.php',
        'Bitrix24\\Presets\\Event\\Event' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/event/event.php',
        'Bitrix24\\Presets\\Event\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/event/fields.php',
        'Bitrix24\\Presets\\Im\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/im/fields.php',
        'Bitrix24\\Presets\\Im\\iChatColor' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/im/ichatcolor.php',
        'Bitrix24\\Presets\\Lang' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/lang.php',
        'Bitrix24\\Presets\\Main' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/main.php',
        'Bitrix24\\Presets\\Placement\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/placement/Fields.php',
        'Bitrix24\\Presets\\Placement\\Placement' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/placement/Placement.php',
        'Bitrix24\\Presets\\Scope' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/scope.php',
        'Bitrix24\\Presets\\Task\\Item\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/task/item/fields.php',
        'Bitrix24\\Presets\\Timing' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/timing.php',
        'Bitrix24\\Presets\\Uri' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/uri.php',
        'Bitrix24\\Presets\\UserFields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/userfields.php',
        'Bitrix24\\Presets\\Users\\Fields' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/presets/users/fields.php',
        'Bitrix24\\Sonet\\SonetGroup' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/sonet/sonetgroup.php',
        'Bitrix24\\Stub\\Bitrix24' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/stub/bitrix24.php',
        'Bitrix24\\Task\\ChecklistItem' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/task/checklistitem.php',
        'Bitrix24\\Task\\CommentItem' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/task/commentitem.php',
        'Bitrix24\\Task\\ElapsedItem' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/task/elapseditem.php',
        'Bitrix24\\Task\\Item' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/task/item.php',
        'Bitrix24\\Task\\Items' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/task/items.php',
        'Bitrix24\\Task\\Planner' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/task/planner.php',
        'Bitrix24\\User\\User' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/user/user.php',
        'Bitrix24\\UserfieldType\\UserfieldType' => __DIR__ . '/..' . '/mesilov/bitrix24-php-sdk/src/classes/userfieldtype/UserfieldType.php',
        'Mobile_Detect' => __DIR__ . '/..' . '/mobiledetect/mobiledetectlib/Mobile_Detect.php',
        'Smarty' => __DIR__ . '/..' . '/smarty/smarty/libs/Smarty.class.php',
        'SmartyBC' => __DIR__ . '/..' . '/smarty/smarty/libs/SmartyBC.class.php',
        'SmartyCompilerException' => __DIR__ . '/..' . '/smarty/smarty/libs/Smarty.class.php',
        'SmartyException' => __DIR__ . '/..' . '/smarty/smarty/libs/Smarty.class.php',
        'Smarty_Security' => __DIR__ . '/..' . '/smarty/smarty/libs/sysplugins/smarty_security.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e1ebd80bf262b86e8cece8ac2ff8bd0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e1ebd80bf262b86e8cece8ac2ff8bd0::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9e1ebd80bf262b86e8cece8ac2ff8bd0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit9e1ebd80bf262b86e8cece8ac2ff8bd0::$classMap;

        }, null, ClassLoader::class);
    }
}
