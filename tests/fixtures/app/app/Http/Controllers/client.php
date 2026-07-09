<?php

declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Request;

$request = App::resolve(Request::class);

return $request->params('id');
