<?php

$isEmptyRoute = howRoute() != 'index' && (howRoute() != '' || howRoute() != null);

$services = $db->from('services')
    ->where('service_status', 1)
    ->orderby('service_order')
    ->all();

$about = $db->from('about')->first();
$properties = json_decode($about['properties'], true);

$services = $db->from('services')
    ->where('service_status', 1)
    ->orderby('service_order')
    ->all();
if (route(0) == 'services' && route(1) == '') {
    if (isset($services[0]['service_url'])) {
        header('Location: services/' . $services[0]['service_url']);
        exit;
    }
}

$counters = $db->from('counters')->first();

$feature = $db->from('features')->first();
$features = json_decode($feature['content'], true);

$medias = $db->from('medias')->all();

$teams = $db->from('teams')
    ->where('team_status', 1)
    ->all();

$lastPosts = $db->from('posts')
    ->where('post_status', 1)
    ->orderby('post_id', 'DESC')
    ->limit(0, 3)
    ->all();