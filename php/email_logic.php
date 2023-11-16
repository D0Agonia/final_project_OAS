<?php
require_once(__DIR__ . '/ElasticEmail/vendor/autoload.php');
 
function sendMail($recipient, $subject, $message){
    $config = ElasticEmail\Configuration::getDefaultConfiguration()
        ->setApiKey('X-ElasticEmail-ApiKey', 'B4B9CE82EED5FFB9F3589E1CBA363F489F6A0D9E89AFFBF8BC796CDE1A42C4519F8928387B70EB453CEE3EEC0CDDA7C4');
    
    $apiInstance = new ElasticEmail\Api\EmailsApi(
        new GuzzleHttp\Client(),
        $config
    );
    
    $email = new \ElasticEmail\Model\EmailMessageData(array(
        "recipients" => array(
            new \ElasticEmail\Model\EmailRecipient(array("email" => "$recipient"))
        ),
        "content" => new \ElasticEmail\Model\EmailContent(array(
            "body" => array(
                new \ElasticEmail\Model\BodyPart(array(
                    "content_type" => "HTML",
                    "content" => "$message"
                ))
            ),
            "from" => "noreplykldoas@gmail.com",
            "subject" => "$subject"
        ))
    ));
    
    try {
        $apiInstance->emailsPost($email);
    } catch (Exception $e) {
        echo 'Exception when calling EE API: ', $e->getMessage(), PHP_EOL;
    }
}
?>