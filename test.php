<?php

$json = '[{"__className__":"TestVO"},{"__className__":"TestVO"},{"__className__":"TestVO"}]';

var_dump(json_decode($json));
var_dump(json_decode($json, true));