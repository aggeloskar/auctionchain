<?php

function formatDate($date) {
    return date('F d, Y H:i a (T)', strtotime($date));
}