<?php
/*
 * MIT License
 *
 * Copyright (c) 2023. Baran Arda
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copyof this software and associated documentation files (the "Software"), to dealin the Software without restriction, including without limitation the rightsto use, copy, modify, merge, publish, distribute, sublicense, and/or sellcopies of the Software, and to permit persons to whom the Software isfurnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in allcopies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS ORIMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THEAUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHERLIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THESOFTWARE.
 */

namespace Theposeidonas\VerimorSms\Contracts;

interface VerimorSms
{
    /**
     * @param $msg
     * @param $dest
     * @param $parameters
     * @return mixed
     */
    public function send( $msg, $dest, $parameters = []);

    /**
     * @param $msg
     * @param $dest
     * @param $parameters
     * @return mixed
     */
    public function sendGet( $msg, $dest, $parameters = []);

    /**
     * @return mixed
     */
    public function creditCheck();
}