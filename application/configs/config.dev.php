<?php

$config = array(
    "services" => array(
        "twig" => array(
            "directory" => "/templates"
        ),
        "doctrine" => array(
            "driver" => "pdo_sqlite",
            "path" =>   "data/app.db"
        )
    ),

    "routes" => array(
        "homepage" => array(
            "url" => "/"
        )
    )
);