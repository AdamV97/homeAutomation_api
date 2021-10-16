<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;

class publishMqtt extends Controller
{
    public function turnOnLight(Request $request){
        $state = '';

        if($request['data'] === 'ON'){
            $state = 'ON';
        }else{
            $state = 'OFF';
        }

        $mqtt = MQTT::connection();
        $mqtt->publish('zigbee2mqtt/0x842e14fffe3597db/set', '{"state": "' . $state . '"}', 1);
        $mqtt->loop(true, true);
        $mqtt->disconnect();

        return true;
    }
    
    public function getLightStatus(){
        $status = '';

        $mqtt = MQTT::connection();
        $mqtt->subscribe(env('MQTT_TOPIC_HALLWAYLIGHT'), function (string $topic, string $message) use ($mqtt, &$status) {
            $status = $message;
            $mqtt->interrupt();
        }, MqttClient::QOS_AT_LEAST_ONCE);

        $mqtt->registerLoopEventHandler(function (MqttClient $client, float $elapsedTime) {
            if ($elapsedTime > 10) {
                $client->interrupt();
            }
        });

        $mqtt->publish(env('MQTT_TOPIC_HALLWAYLIGHT') . '/get', '{"state": ""}', MqttClient::QOS_AT_LEAST_ONCE);
        $mqtt->loop();
        $mqtt->disconnect();

        return $status;
    }
}
