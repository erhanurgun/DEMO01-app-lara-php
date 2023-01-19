<?php

if (!permission('others', 'show')){
    permissionPage();
}

$sliders = $db->from('sliders')
    ->orderby('slid_order')
    ->all();

$counters = $db->from('counters')->first();

$teams = $db->from('teams')
    ->orderby('team_order')
    ->all();

$feature = $db->from('features')->first();
$features = json_decode($feature['content'], true);

$about = $db->from('about')->first();
$properties = json_decode($about['properties'], true);

require adminView('others');