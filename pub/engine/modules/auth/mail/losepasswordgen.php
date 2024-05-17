<?php

function generatecode($mail) {
    return bin2hex(random_bytes(16));
}