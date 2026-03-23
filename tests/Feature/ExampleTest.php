<?php

test('guests visiting home are redirected to login', function () {
    $this->get(route('home'))->assertRedirect(route('login'));
});
