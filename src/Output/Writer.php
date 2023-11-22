<?php

/**
 * Platine Console
 *
 * Platine Console is a powerful library with support of custom
 * style to build command line interface applications
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2020 Platine Console
 * Copyright (c) 2017-2020 Jitendra Adhikari
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 *  @file Writer.php
 *
 *  The Output Writer class
 *
 *  @package    Platine\Console\Output
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   https://www.platine-php.com
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Output;

/**
 * Class Writer
 * @package Platine\Console\Output
 *
 * @method Writer bold(string $text, bool $eol = false)
 * @method Writer dim(string $text, bool $eol = false)
 * @method Writer italic(string $text, bool $eol = false)
 * @method Writer underline(string $text, bool $eol = false)
 * @method Writer black(string $text, bool $eol = false)
 * @method Writer red(string $text, bool $eol = false)
 * @method Writer green(string $text, bool $eol = false)
 * @method Writer yellow(string $text, bool $eol = false)
 * @method Writer blue(string $text, bool $eol = false)
 * @method Writer purple(string $text, bool $eol = false)
 * @method Writer cyan(string $text, bool $eol = false)
 * @method Writer white(string $text, bool $eol = false)
 * @method Writer gray(string $text, bool $eol = false)
 * @method Writer darkgray(string $text, bool $eol = false)
 * @method Writer bgBlack(string $text, bool $eol = false)
 * @method Writer bgRed(string $text, bool $eol = false)
 * @method Writer bgGreen(string $text, bool $eol = false)
 * @method Writer bgYellow(string $text, bool $eol = false)
 * @method Writer bgBlue(string $text, bool $eol = false)
 * @method Writer bgPurple(string $text, bool $eol = false)
 * @method Writer bgCyan(string $text, bool $eol = false)
 * @method Writer bgWhite(string $text, bool $eol = false)
 * @method Writer bgGray(string $text, bool $eol = false)
 * @method Writer bgDarkgray(string $text, bool $eol = false)
 * @method Writer boldBlack(string $text, bool $eol = false)
 * @method Writer boldRed(string $text, bool $eol = false)
 * @method Writer boldGreen(string $text, bool $eol = false)
 * @method Writer boldYellow(string $text, bool $eol = false)
 * @method Writer boldBlue(string $text, bool $eol = false)
 * @method Writer boldPurple(string $text, bool $eol = false)
 * @method Writer boldCyan(string $text, bool $eol = false)
 * @method Writer boldWhite(string $text, bool $eol = false)
 * @method Writer boldGray(string $text, bool $eol = false)
 * @method Writer boldDarkgray(string $text, bool $eol = false)
 * @method Writer dimBlack(string $text, bool $eol = false)
 * @method Writer dimRed(string $text, bool $eol = false)
 * @method Writer dimGreen(string $text, bool $eol = false)
 * @method Writer dimYellow(string $text, bool $eol = false)
 * @method Writer dimBlue(string $text, bool $eol = false)
 * @method Writer dimPurple(string $text, bool $eol = false)
 * @method Writer dimCyan(string $text, bool $eol = false)
 * @method Writer dimWhite(string $text, bool $eol = false)
 * @method Writer dimGray(string $text, bool $eol = false)
 * @method Writer dimDarkgray(string $text, bool $eol = false)
 * @method Writer italicBlack(string $text, bool $eol = false)
 * @method Writer italicRed(string $text, bool $eol = false)
 * @method Writer italicGreen(string $text, bool $eol = false)
 * @method Writer italicYellow(string $text, bool $eol = false)
 * @method Writer italicBlue(string $text, bool $eol = false)
 * @method Writer italicPurple(string $text, bool $eol = false)
 * @method Writer italicCyan(string $text, bool $eol = false)
 * @method Writer italicWhite(string $text, bool $eol = false)
 * @method Writer italicGray(string $text, bool $eol = false)
 * @method Writer italicDarkgray(string $text, bool $eol = false)
 * @method Writer underlineBlack(string $text, bool $eol = false)
 * @method Writer underlineRed(string $text, bool $eol = false)
 * @method Writer underlineGreen(string $text, bool $eol = false)
 * @method Writer underlineYellow(string $text, bool $eol = false)
 * @method Writer underlineBlue(string $text, bool $eol = false)
 * @method Writer underlinePurple(string $text, bool $eol = false)
 * @method Writer underlineCyan(string $text, bool $eol = false)
 * @method Writer underlineWhite(string $text, bool $eol = false)
 * @method Writer underlineGray(string $text, bool $eol = false)
 * @method Writer underlineDarkgray(string $text, bool $eol = false)
 * @method Writer boldBgBlack(string $text, bool $eol = false)
 * @method Writer boldBgRed(string $text, bool $eol = false)
 * @method Writer boldBgGreen(string $text, bool $eol = false)
 * @method Writer boldBgYellow(string $text, bool $eol = false)
 * @method Writer boldBgBlue(string $text, bool $eol = false)
 * @method Writer boldBgPurple(string $text, bool $eol = false)
 * @method Writer boldBgCyan(string $text, bool $eol = false)
 * @method Writer boldBgWhite(string $text, bool $eol = false)
 * @method Writer boldBgGray(string $text, bool $eol = false)
 * @method Writer boldBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimBgBlack(string $text, bool $eol = false)
 * @method Writer dimBgRed(string $text, bool $eol = false)
 * @method Writer dimBgGreen(string $text, bool $eol = false)
 * @method Writer dimBgYellow(string $text, bool $eol = false)
 * @method Writer dimBgBlue(string $text, bool $eol = false)
 * @method Writer dimBgPurple(string $text, bool $eol = false)
 * @method Writer dimBgCyan(string $text, bool $eol = false)
 * @method Writer dimBgWhite(string $text, bool $eol = false)
 * @method Writer dimBgGray(string $text, bool $eol = false)
 * @method Writer dimBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicBgBlack(string $text, bool $eol = false)
 * @method Writer italicBgRed(string $text, bool $eol = false)
 * @method Writer italicBgGreen(string $text, bool $eol = false)
 * @method Writer italicBgYellow(string $text, bool $eol = false)
 * @method Writer italicBgBlue(string $text, bool $eol = false)
 * @method Writer italicBgPurple(string $text, bool $eol = false)
 * @method Writer italicBgCyan(string $text, bool $eol = false)
 * @method Writer italicBgWhite(string $text, bool $eol = false)
 * @method Writer italicBgGray(string $text, bool $eol = false)
 * @method Writer italicBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineBgBlack(string $text, bool $eol = false)
 * @method Writer underlineBgRed(string $text, bool $eol = false)
 * @method Writer underlineBgGreen(string $text, bool $eol = false)
 * @method Writer underlineBgYellow(string $text, bool $eol = false)
 * @method Writer underlineBgBlue(string $text, bool $eol = false)
 * @method Writer underlineBgPurple(string $text, bool $eol = false)
 * @method Writer underlineBgCyan(string $text, bool $eol = false)
 * @method Writer underlineBgWhite(string $text, bool $eol = false)
 * @method Writer underlineBgGray(string $text, bool $eol = false)
 * @method Writer underlineBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldBlackBgRed(string $text, bool $eol = false)
 * @method Writer boldBlackBgGreen(string $text, bool $eol = false)
 * @method Writer boldBlackBgYellow(string $text, bool $eol = false)
 * @method Writer boldBlackBgBlue(string $text, bool $eol = false)
 * @method Writer boldBlackBgPurple(string $text, bool $eol = false)
 * @method Writer boldBlackBgCyan(string $text, bool $eol = false)
 * @method Writer boldBlackBgWhite(string $text, bool $eol = false)
 * @method Writer boldBlackBgGray(string $text, bool $eol = false)
 * @method Writer boldBlackBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldRedBgBlack(string $text, bool $eol = false)
 * @method Writer boldRedBgGreen(string $text, bool $eol = false)
 * @method Writer boldRedBgYellow(string $text, bool $eol = false)
 * @method Writer boldRedBgBlue(string $text, bool $eol = false)
 * @method Writer boldRedBgPurple(string $text, bool $eol = false)
 * @method Writer boldRedBgCyan(string $text, bool $eol = false)
 * @method Writer boldRedBgWhite(string $text, bool $eol = false)
 * @method Writer boldRedBgGray(string $text, bool $eol = false)
 * @method Writer boldRedBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldGreenBgBlack(string $text, bool $eol = false)
 * @method Writer boldGreenBgRed(string $text, bool $eol = false)
 * @method Writer boldGreenBgYellow(string $text, bool $eol = false)
 * @method Writer boldGreenBgBlue(string $text, bool $eol = false)
 * @method Writer boldGreenBgPurple(string $text, bool $eol = false)
 * @method Writer boldGreenBgCyan(string $text, bool $eol = false)
 * @method Writer boldGreenBgWhite(string $text, bool $eol = false)
 * @method Writer boldGreenBgGray(string $text, bool $eol = false)
 * @method Writer boldGreenBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldYellowBgBlack(string $text, bool $eol = false)
 * @method Writer boldYellowBgRed(string $text, bool $eol = false)
 * @method Writer boldYellowBgGreen(string $text, bool $eol = false)
 * @method Writer boldYellowBgBlue(string $text, bool $eol = false)
 * @method Writer boldYellowBgPurple(string $text, bool $eol = false)
 * @method Writer boldYellowBgCyan(string $text, bool $eol = false)
 * @method Writer boldYellowBgWhite(string $text, bool $eol = false)
 * @method Writer boldYellowBgGray(string $text, bool $eol = false)
 * @method Writer boldYellowBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldBlueBgBlack(string $text, bool $eol = false)
 * @method Writer boldBlueBgRed(string $text, bool $eol = false)
 * @method Writer boldBlueBgGreen(string $text, bool $eol = false)
 * @method Writer boldBlueBgYellow(string $text, bool $eol = false)
 * @method Writer boldBlueBgPurple(string $text, bool $eol = false)
 * @method Writer boldBlueBgCyan(string $text, bool $eol = false)
 * @method Writer boldBlueBgWhite(string $text, bool $eol = false)
 * @method Writer boldBlueBgGray(string $text, bool $eol = false)
 * @method Writer boldBlueBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldPurpleBgBlack(string $text, bool $eol = false)
 * @method Writer boldPurpleBgRed(string $text, bool $eol = false)
 * @method Writer boldPurpleBgGreen(string $text, bool $eol = false)
 * @method Writer boldPurpleBgYellow(string $text, bool $eol = false)
 * @method Writer boldPurpleBgBlue(string $text, bool $eol = false)
 * @method Writer boldPurpleBgCyan(string $text, bool $eol = false)
 * @method Writer boldPurpleBgWhite(string $text, bool $eol = false)
 * @method Writer boldPurpleBgGray(string $text, bool $eol = false)
 * @method Writer boldPurpleBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldCyanBgBlack(string $text, bool $eol = false)
 * @method Writer boldCyanBgRed(string $text, bool $eol = false)
 * @method Writer boldCyanBgGreen(string $text, bool $eol = false)
 * @method Writer boldCyanBgYellow(string $text, bool $eol = false)
 * @method Writer boldCyanBgBlue(string $text, bool $eol = false)
 * @method Writer boldCyanBgPurple(string $text, bool $eol = false)
 * @method Writer boldCyanBgWhite(string $text, bool $eol = false)
 * @method Writer boldCyanBgGray(string $text, bool $eol = false)
 * @method Writer boldCyanBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldWhiteBgBlack(string $text, bool $eol = false)
 * @method Writer boldWhiteBgRed(string $text, bool $eol = false)
 * @method Writer boldWhiteBgGreen(string $text, bool $eol = false)
 * @method Writer boldWhiteBgYellow(string $text, bool $eol = false)
 * @method Writer boldWhiteBgBlue(string $text, bool $eol = false)
 * @method Writer boldWhiteBgPurple(string $text, bool $eol = false)
 * @method Writer boldWhiteBgCyan(string $text, bool $eol = false)
 * @method Writer boldWhiteBgGray(string $text, bool $eol = false)
 * @method Writer boldWhiteBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldGrayBgBlack(string $text, bool $eol = false)
 * @method Writer boldGrayBgRed(string $text, bool $eol = false)
 * @method Writer boldGrayBgGreen(string $text, bool $eol = false)
 * @method Writer boldGrayBgYellow(string $text, bool $eol = false)
 * @method Writer boldGrayBgBlue(string $text, bool $eol = false)
 * @method Writer boldGrayBgPurple(string $text, bool $eol = false)
 * @method Writer boldGrayBgCyan(string $text, bool $eol = false)
 * @method Writer boldGrayBgWhite(string $text, bool $eol = false)
 * @method Writer boldGrayBgDarkgray(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgBlack(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgRed(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgGreen(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgYellow(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgBlue(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgPurple(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgCyan(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgWhite(string $text, bool $eol = false)
 * @method Writer boldDarkgrayBgGray(string $text, bool $eol = false)
 * @method Writer dimBlackBgRed(string $text, bool $eol = false)
 * @method Writer dimBlackBgGreen(string $text, bool $eol = false)
 * @method Writer dimBlackBgYellow(string $text, bool $eol = false)
 * @method Writer dimBlackBgBlue(string $text, bool $eol = false)
 * @method Writer dimBlackBgPurple(string $text, bool $eol = false)
 * @method Writer dimBlackBgCyan(string $text, bool $eol = false)
 * @method Writer dimBlackBgWhite(string $text, bool $eol = false)
 * @method Writer dimBlackBgGray(string $text, bool $eol = false)
 * @method Writer dimBlackBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimRedBgBlack(string $text, bool $eol = false)
 * @method Writer dimRedBgGreen(string $text, bool $eol = false)
 * @method Writer dimRedBgYellow(string $text, bool $eol = false)
 * @method Writer dimRedBgBlue(string $text, bool $eol = false)
 * @method Writer dimRedBgPurple(string $text, bool $eol = false)
 * @method Writer dimRedBgCyan(string $text, bool $eol = false)
 * @method Writer dimRedBgWhite(string $text, bool $eol = false)
 * @method Writer dimRedBgGray(string $text, bool $eol = false)
 * @method Writer dimRedBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimGreenBgBlack(string $text, bool $eol = false)
 * @method Writer dimGreenBgRed(string $text, bool $eol = false)
 * @method Writer dimGreenBgYellow(string $text, bool $eol = false)
 * @method Writer dimGreenBgBlue(string $text, bool $eol = false)
 * @method Writer dimGreenBgPurple(string $text, bool $eol = false)
 * @method Writer dimGreenBgCyan(string $text, bool $eol = false)
 * @method Writer dimGreenBgWhite(string $text, bool $eol = false)
 * @method Writer dimGreenBgGray(string $text, bool $eol = false)
 * @method Writer dimGreenBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimYellowBgBlack(string $text, bool $eol = false)
 * @method Writer dimYellowBgRed(string $text, bool $eol = false)
 * @method Writer dimYellowBgGreen(string $text, bool $eol = false)
 * @method Writer dimYellowBgBlue(string $text, bool $eol = false)
 * @method Writer dimYellowBgPurple(string $text, bool $eol = false)
 * @method Writer dimYellowBgCyan(string $text, bool $eol = false)
 * @method Writer dimYellowBgWhite(string $text, bool $eol = false)
 * @method Writer dimYellowBgGray(string $text, bool $eol = false)
 * @method Writer dimYellowBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimBlueBgBlack(string $text, bool $eol = false)
 * @method Writer dimBlueBgRed(string $text, bool $eol = false)
 * @method Writer dimBlueBgGreen(string $text, bool $eol = false)
 * @method Writer dimBlueBgYellow(string $text, bool $eol = false)
 * @method Writer dimBlueBgPurple(string $text, bool $eol = false)
 * @method Writer dimBlueBgCyan(string $text, bool $eol = false)
 * @method Writer dimBlueBgWhite(string $text, bool $eol = false)
 * @method Writer dimBlueBgGray(string $text, bool $eol = false)
 * @method Writer dimBlueBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimPurpleBgBlack(string $text, bool $eol = false)
 * @method Writer dimPurpleBgRed(string $text, bool $eol = false)
 * @method Writer dimPurpleBgGreen(string $text, bool $eol = false)
 * @method Writer dimPurpleBgYellow(string $text, bool $eol = false)
 * @method Writer dimPurpleBgBlue(string $text, bool $eol = false)
 * @method Writer dimPurpleBgCyan(string $text, bool $eol = false)
 * @method Writer dimPurpleBgWhite(string $text, bool $eol = false)
 * @method Writer dimPurpleBgGray(string $text, bool $eol = false)
 * @method Writer dimPurpleBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimCyanBgBlack(string $text, bool $eol = false)
 * @method Writer dimCyanBgRed(string $text, bool $eol = false)
 * @method Writer dimCyanBgGreen(string $text, bool $eol = false)
 * @method Writer dimCyanBgYellow(string $text, bool $eol = false)
 * @method Writer dimCyanBgBlue(string $text, bool $eol = false)
 * @method Writer dimCyanBgPurple(string $text, bool $eol = false)
 * @method Writer dimCyanBgWhite(string $text, bool $eol = false)
 * @method Writer dimCyanBgGray(string $text, bool $eol = false)
 * @method Writer dimCyanBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimWhiteBgBlack(string $text, bool $eol = false)
 * @method Writer dimWhiteBgRed(string $text, bool $eol = false)
 * @method Writer dimWhiteBgGreen(string $text, bool $eol = false)
 * @method Writer dimWhiteBgYellow(string $text, bool $eol = false)
 * @method Writer dimWhiteBgBlue(string $text, bool $eol = false)
 * @method Writer dimWhiteBgPurple(string $text, bool $eol = false)
 * @method Writer dimWhiteBgCyan(string $text, bool $eol = false)
 * @method Writer dimWhiteBgGray(string $text, bool $eol = false)
 * @method Writer dimWhiteBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimGrayBgBlack(string $text, bool $eol = false)
 * @method Writer dimGrayBgRed(string $text, bool $eol = false)
 * @method Writer dimGrayBgGreen(string $text, bool $eol = false)
 * @method Writer dimGrayBgYellow(string $text, bool $eol = false)
 * @method Writer dimGrayBgBlue(string $text, bool $eol = false)
 * @method Writer dimGrayBgPurple(string $text, bool $eol = false)
 * @method Writer dimGrayBgCyan(string $text, bool $eol = false)
 * @method Writer dimGrayBgWhite(string $text, bool $eol = false)
 * @method Writer dimGrayBgDarkgray(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgBlack(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgRed(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgGreen(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgYellow(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgBlue(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgPurple(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgCyan(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgWhite(string $text, bool $eol = false)
 * @method Writer dimDarkgrayBgGray(string $text, bool $eol = false)
 * @method Writer italicBlackBgRed(string $text, bool $eol = false)
 * @method Writer italicBlackBgGreen(string $text, bool $eol = false)
 * @method Writer italicBlackBgYellow(string $text, bool $eol = false)
 * @method Writer italicBlackBgBlue(string $text, bool $eol = false)
 * @method Writer italicBlackBgPurple(string $text, bool $eol = false)
 * @method Writer italicBlackBgCyan(string $text, bool $eol = false)
 * @method Writer italicBlackBgWhite(string $text, bool $eol = false)
 * @method Writer italicBlackBgGray(string $text, bool $eol = false)
 * @method Writer italicBlackBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicRedBgBlack(string $text, bool $eol = false)
 * @method Writer italicRedBgGreen(string $text, bool $eol = false)
 * @method Writer italicRedBgYellow(string $text, bool $eol = false)
 * @method Writer italicRedBgBlue(string $text, bool $eol = false)
 * @method Writer italicRedBgPurple(string $text, bool $eol = false)
 * @method Writer italicRedBgCyan(string $text, bool $eol = false)
 * @method Writer italicRedBgWhite(string $text, bool $eol = false)
 * @method Writer italicRedBgGray(string $text, bool $eol = false)
 * @method Writer italicRedBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicGreenBgBlack(string $text, bool $eol = false)
 * @method Writer italicGreenBgRed(string $text, bool $eol = false)
 * @method Writer italicGreenBgYellow(string $text, bool $eol = false)
 * @method Writer italicGreenBgBlue(string $text, bool $eol = false)
 * @method Writer italicGreenBgPurple(string $text, bool $eol = false)
 * @method Writer italicGreenBgCyan(string $text, bool $eol = false)
 * @method Writer italicGreenBgWhite(string $text, bool $eol = false)
 * @method Writer italicGreenBgGray(string $text, bool $eol = false)
 * @method Writer italicGreenBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicYellowBgBlack(string $text, bool $eol = false)
 * @method Writer italicYellowBgRed(string $text, bool $eol = false)
 * @method Writer italicYellowBgGreen(string $text, bool $eol = false)
 * @method Writer italicYellowBgBlue(string $text, bool $eol = false)
 * @method Writer italicYellowBgPurple(string $text, bool $eol = false)
 * @method Writer italicYellowBgCyan(string $text, bool $eol = false)
 * @method Writer italicYellowBgWhite(string $text, bool $eol = false)
 * @method Writer italicYellowBgGray(string $text, bool $eol = false)
 * @method Writer italicYellowBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicBlueBgBlack(string $text, bool $eol = false)
 * @method Writer italicBlueBgRed(string $text, bool $eol = false)
 * @method Writer italicBlueBgGreen(string $text, bool $eol = false)
 * @method Writer italicBlueBgYellow(string $text, bool $eol = false)
 * @method Writer italicBlueBgPurple(string $text, bool $eol = false)
 * @method Writer italicBlueBgCyan(string $text, bool $eol = false)
 * @method Writer italicBlueBgWhite(string $text, bool $eol = false)
 * @method Writer italicBlueBgGray(string $text, bool $eol = false)
 * @method Writer italicBlueBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicPurpleBgBlack(string $text, bool $eol = false)
 * @method Writer italicPurpleBgRed(string $text, bool $eol = false)
 * @method Writer italicPurpleBgGreen(string $text, bool $eol = false)
 * @method Writer italicPurpleBgYellow(string $text, bool $eol = false)
 * @method Writer italicPurpleBgBlue(string $text, bool $eol = false)
 * @method Writer italicPurpleBgCyan(string $text, bool $eol = false)
 * @method Writer italicPurpleBgWhite(string $text, bool $eol = false)
 * @method Writer italicPurpleBgGray(string $text, bool $eol = false)
 * @method Writer italicPurpleBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicCyanBgBlack(string $text, bool $eol = false)
 * @method Writer italicCyanBgRed(string $text, bool $eol = false)
 * @method Writer italicCyanBgGreen(string $text, bool $eol = false)
 * @method Writer italicCyanBgYellow(string $text, bool $eol = false)
 * @method Writer italicCyanBgBlue(string $text, bool $eol = false)
 * @method Writer italicCyanBgPurple(string $text, bool $eol = false)
 * @method Writer italicCyanBgWhite(string $text, bool $eol = false)
 * @method Writer italicCyanBgGray(string $text, bool $eol = false)
 * @method Writer italicCyanBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicWhiteBgBlack(string $text, bool $eol = false)
 * @method Writer italicWhiteBgRed(string $text, bool $eol = false)
 * @method Writer italicWhiteBgGreen(string $text, bool $eol = false)
 * @method Writer italicWhiteBgYellow(string $text, bool $eol = false)
 * @method Writer italicWhiteBgBlue(string $text, bool $eol = false)
 * @method Writer italicWhiteBgPurple(string $text, bool $eol = false)
 * @method Writer italicWhiteBgCyan(string $text, bool $eol = false)
 * @method Writer italicWhiteBgGray(string $text, bool $eol = false)
 * @method Writer italicWhiteBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicGrayBgBlack(string $text, bool $eol = false)
 * @method Writer italicGrayBgRed(string $text, bool $eol = false)
 * @method Writer italicGrayBgGreen(string $text, bool $eol = false)
 * @method Writer italicGrayBgYellow(string $text, bool $eol = false)
 * @method Writer italicGrayBgBlue(string $text, bool $eol = false)
 * @method Writer italicGrayBgPurple(string $text, bool $eol = false)
 * @method Writer italicGrayBgCyan(string $text, bool $eol = false)
 * @method Writer italicGrayBgWhite(string $text, bool $eol = false)
 * @method Writer italicGrayBgDarkgray(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgBlack(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgRed(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgGreen(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgYellow(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgBlue(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgPurple(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgCyan(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgWhite(string $text, bool $eol = false)
 * @method Writer italicDarkgrayBgGray(string $text, bool $eol = false)
 * @method Writer underlineBlackBgRed(string $text, bool $eol = false)
 * @method Writer underlineBlackBgGreen(string $text, bool $eol = false)
 * @method Writer underlineBlackBgYellow(string $text, bool $eol = false)
 * @method Writer underlineBlackBgBlue(string $text, bool $eol = false)
 * @method Writer underlineBlackBgPurple(string $text, bool $eol = false)
 * @method Writer underlineBlackBgCyan(string $text, bool $eol = false)
 * @method Writer underlineBlackBgWhite(string $text, bool $eol = false)
 * @method Writer underlineBlackBgGray(string $text, bool $eol = false)
 * @method Writer underlineBlackBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineRedBgBlack(string $text, bool $eol = false)
 * @method Writer underlineRedBgGreen(string $text, bool $eol = false)
 * @method Writer underlineRedBgYellow(string $text, bool $eol = false)
 * @method Writer underlineRedBgBlue(string $text, bool $eol = false)
 * @method Writer underlineRedBgPurple(string $text, bool $eol = false)
 * @method Writer underlineRedBgCyan(string $text, bool $eol = false)
 * @method Writer underlineRedBgWhite(string $text, bool $eol = false)
 * @method Writer underlineRedBgGray(string $text, bool $eol = false)
 * @method Writer underlineRedBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineGreenBgBlack(string $text, bool $eol = false)
 * @method Writer underlineGreenBgRed(string $text, bool $eol = false)
 * @method Writer underlineGreenBgYellow(string $text, bool $eol = false)
 * @method Writer underlineGreenBgBlue(string $text, bool $eol = false)
 * @method Writer underlineGreenBgPurple(string $text, bool $eol = false)
 * @method Writer underlineGreenBgCyan(string $text, bool $eol = false)
 * @method Writer underlineGreenBgWhite(string $text, bool $eol = false)
 * @method Writer underlineGreenBgGray(string $text, bool $eol = false)
 * @method Writer underlineGreenBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineYellowBgBlack(string $text, bool $eol = false)
 * @method Writer underlineYellowBgRed(string $text, bool $eol = false)
 * @method Writer underlineYellowBgGreen(string $text, bool $eol = false)
 * @method Writer underlineYellowBgBlue(string $text, bool $eol = false)
 * @method Writer underlineYellowBgPurple(string $text, bool $eol = false)
 * @method Writer underlineYellowBgCyan(string $text, bool $eol = false)
 * @method Writer underlineYellowBgWhite(string $text, bool $eol = false)
 * @method Writer underlineYellowBgGray(string $text, bool $eol = false)
 * @method Writer underlineYellowBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineBlueBgBlack(string $text, bool $eol = false)
 * @method Writer underlineBlueBgRed(string $text, bool $eol = false)
 * @method Writer underlineBlueBgGreen(string $text, bool $eol = false)
 * @method Writer underlineBlueBgYellow(string $text, bool $eol = false)
 * @method Writer underlineBlueBgPurple(string $text, bool $eol = false)
 * @method Writer underlineBlueBgCyan(string $text, bool $eol = false)
 * @method Writer underlineBlueBgWhite(string $text, bool $eol = false)
 * @method Writer underlineBlueBgGray(string $text, bool $eol = false)
 * @method Writer underlineBlueBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgBlack(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgRed(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgGreen(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgYellow(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgBlue(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgCyan(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgWhite(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgGray(string $text, bool $eol = false)
 * @method Writer underlinePurpleBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineCyanBgBlack(string $text, bool $eol = false)
 * @method Writer underlineCyanBgRed(string $text, bool $eol = false)
 * @method Writer underlineCyanBgGreen(string $text, bool $eol = false)
 * @method Writer underlineCyanBgYellow(string $text, bool $eol = false)
 * @method Writer underlineCyanBgBlue(string $text, bool $eol = false)
 * @method Writer underlineCyanBgPurple(string $text, bool $eol = false)
 * @method Writer underlineCyanBgWhite(string $text, bool $eol = false)
 * @method Writer underlineCyanBgGray(string $text, bool $eol = false)
 * @method Writer underlineCyanBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgBlack(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgRed(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgGreen(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgYellow(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgBlue(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgPurple(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgCyan(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgGray(string $text, bool $eol = false)
 * @method Writer underlineWhiteBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineGrayBgBlack(string $text, bool $eol = false)
 * @method Writer underlineGrayBgRed(string $text, bool $eol = false)
 * @method Writer underlineGrayBgGreen(string $text, bool $eol = false)
 * @method Writer underlineGrayBgYellow(string $text, bool $eol = false)
 * @method Writer underlineGrayBgBlue(string $text, bool $eol = false)
 * @method Writer underlineGrayBgPurple(string $text, bool $eol = false)
 * @method Writer underlineGrayBgCyan(string $text, bool $eol = false)
 * @method Writer underlineGrayBgWhite(string $text, bool $eol = false)
 * @method Writer underlineGrayBgDarkgray(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgBlack(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgRed(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgGreen(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgYellow(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgBlue(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgPurple(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgCyan(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgWhite(string $text, bool $eol = false)
 * @method Writer underlineDarkgrayBgGray(string $text, bool $eol = false)
 * @method Writer blackBgRed(string $text, bool $eol = false)
 * @method Writer blackBgGreen(string $text, bool $eol = false)
 * @method Writer blackBgYellow(string $text, bool $eol = false)
 * @method Writer blackBgBlue(string $text, bool $eol = false)
 * @method Writer blackBgPurple(string $text, bool $eol = false)
 * @method Writer blackBgCyan(string $text, bool $eol = false)
 * @method Writer blackBgWhite(string $text, bool $eol = false)
 * @method Writer blackBgGray(string $text, bool $eol = false)
 * @method Writer blackBgDarkgray(string $text, bool $eol = false)
 * @method Writer redBgBlack(string $text, bool $eol = false)
 * @method Writer redBgGreen(string $text, bool $eol = false)
 * @method Writer redBgYellow(string $text, bool $eol = false)
 * @method Writer redBgBlue(string $text, bool $eol = false)
 * @method Writer redBgPurple(string $text, bool $eol = false)
 * @method Writer redBgCyan(string $text, bool $eol = false)
 * @method Writer redBgWhite(string $text, bool $eol = false)
 * @method Writer redBgGray(string $text, bool $eol = false)
 * @method Writer redBgDarkgray(string $text, bool $eol = false)
 * @method Writer greenBgBlack(string $text, bool $eol = false)
 * @method Writer greenBgRed(string $text, bool $eol = false)
 * @method Writer greenBgYellow(string $text, bool $eol = false)
 * @method Writer greenBgBlue(string $text, bool $eol = false)
 * @method Writer greenBgPurple(string $text, bool $eol = false)
 * @method Writer greenBgCyan(string $text, bool $eol = false)
 * @method Writer greenBgWhite(string $text, bool $eol = false)
 * @method Writer greenBgGray(string $text, bool $eol = false)
 * @method Writer greenBgDarkgray(string $text, bool $eol = false)
 * @method Writer yellowBgBlack(string $text, bool $eol = false)
 * @method Writer yellowBgRed(string $text, bool $eol = false)
 * @method Writer yellowBgGreen(string $text, bool $eol = false)
 * @method Writer yellowBgBlue(string $text, bool $eol = false)
 * @method Writer yellowBgPurple(string $text, bool $eol = false)
 * @method Writer yellowBgCyan(string $text, bool $eol = false)
 * @method Writer yellowBgWhite(string $text, bool $eol = false)
 * @method Writer yellowBgGray(string $text, bool $eol = false)
 * @method Writer yellowBgDarkgray(string $text, bool $eol = false)
 * @method Writer blueBgBlack(string $text, bool $eol = false)
 * @method Writer blueBgRed(string $text, bool $eol = false)
 * @method Writer blueBgGreen(string $text, bool $eol = false)
 * @method Writer blueBgYellow(string $text, bool $eol = false)
 * @method Writer blueBgPurple(string $text, bool $eol = false)
 * @method Writer blueBgCyan(string $text, bool $eol = false)
 * @method Writer blueBgWhite(string $text, bool $eol = false)
 * @method Writer blueBgGray(string $text, bool $eol = false)
 * @method Writer blueBgDarkgray(string $text, bool $eol = false)
 * @method Writer purpleBgBlack(string $text, bool $eol = false)
 * @method Writer purpleBgRed(string $text, bool $eol = false)
 * @method Writer purpleBgGreen(string $text, bool $eol = false)
 * @method Writer purpleBgYellow(string $text, bool $eol = false)
 * @method Writer purpleBgBlue(string $text, bool $eol = false)
 * @method Writer purpleBgCyan(string $text, bool $eol = false)
 * @method Writer purpleBgWhite(string $text, bool $eol = false)
 * @method Writer purpleBgGray(string $text, bool $eol = false)
 * @method Writer purpleBgDarkgray(string $text, bool $eol = false)
 * @method Writer cyanBgBlack(string $text, bool $eol = false)
 * @method Writer cyanBgRed(string $text, bool $eol = false)
 * @method Writer cyanBgGreen(string $text, bool $eol = false)
 * @method Writer cyanBgYellow(string $text, bool $eol = false)
 * @method Writer cyanBgBlue(string $text, bool $eol = false)
 * @method Writer cyanBgPurple(string $text, bool $eol = false)
 * @method Writer cyanBgWhite(string $text, bool $eol = false)
 * @method Writer cyanBgGray(string $text, bool $eol = false)
 * @method Writer cyanBgDarkgray(string $text, bool $eol = false)
 * @method Writer whiteBgBlack(string $text, bool $eol = false)
 * @method Writer whiteBgRed(string $text, bool $eol = false)
 * @method Writer whiteBgGreen(string $text, bool $eol = false)
 * @method Writer whiteBgYellow(string $text, bool $eol = false)
 * @method Writer whiteBgBlue(string $text, bool $eol = false)
 * @method Writer whiteBgPurple(string $text, bool $eol = false)
 * @method Writer whiteBgCyan(string $text, bool $eol = false)
 * @method Writer whiteBgGray(string $text, bool $eol = false)
 * @method Writer whiteBgDarkgray(string $text, bool $eol = false)
 * @method Writer grayBgBlack(string $text, bool $eol = false)
 * @method Writer grayBgRed(string $text, bool $eol = false)
 * @method Writer grayBgGreen(string $text, bool $eol = false)
 * @method Writer grayBgYellow(string $text, bool $eol = false)
 * @method Writer grayBgBlue(string $text, bool $eol = false)
 * @method Writer grayBgPurple(string $text, bool $eol = false)
 * @method Writer grayBgCyan(string $text, bool $eol = false)
 * @method Writer grayBgWhite(string $text, bool $eol = false)
 * @method Writer grayBgDarkgray(string $text, bool $eol = false)
 * @method Writer darkgrayBgBlack(string $text, bool $eol = false)
 * @method Writer darkgrayBgRed(string $text, bool $eol = false)
 * @method Writer darkgrayBgGreen(string $text, bool $eol = false)
 * @method Writer darkgrayBgYellow(string $text, bool $eol = false)
 * @method Writer darkgrayBgBlue(string $text, bool $eol = false)
 * @method Writer darkgrayBgPurple(string $text, bool $eol = false)
 * @method Writer darkgrayBgCyan(string $text, bool $eol = false)
 * @method Writer darkgrayBgWhite(string $text, bool $eol = false)
 * @method Writer darkgrayBgGray(string $text, bool $eol = false)
 */
class Writer
{
    /**
     * The output stream
     * @var resource
     */
    protected $stream;

    /**
     * The output error stream
     * @var resource
     */
    protected $errorStream;

    /**
     * Color method to be called
     * @var string
     */
    protected string $method = '';

    /**
     * The color instance
     * @var Color
     */
    protected Color $color;

    /**
     * The cursor instance
     * @var Cursor
     */
    protected Cursor $cursor;

    /**
     * Create new instance
     * @param string|null $path the output write path
     * @param Color|null $color the color instance
     */
    public function __construct(?string $path = null, ?Color $color = null)
    {
        $stream = null;
        if ($path !== null) {
            $stream = fopen($path, 'w');
        }

        $this->stream = $stream ?? STDOUT;
        $this->errorStream = $stream ?? STDERR;

        $this->color = $color ?? new Color();
        $this->cursor = new Cursor();
    }
    
    /**
     * Set the stream
     * @param resource $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
        return $this;
    }
    
    /**
     * Set the error stream
     * @param resource $stream
     * @return $this
     */
    public function setErrorStream($stream)
    {
        $this->errorStream = $stream;
        return $this;
    }

    /**
     * Return the color instance
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * Return the cursor instance
     * @return Cursor
     */
    public function getCursor(): Cursor
    {
        return $this->cursor;
    }

    /**
     * Write the formatted text to standard output.
     * @param string $text
     * @param bool $eol
     * @return $this
     */
    public function write(string $text, bool $eol = false): self
    {
        $method = 'line';
        if (!empty($this->method)) {
            $method = $this->method;
            $this->method = '';
        }

        $styledText = $this->color->{$method}($text);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text to standard error.
     * @param string $text
     * @param bool $eol
     * @return $this
     */
    public function writeError(string $text, bool $eol = false): self
    {
        $styledText = $this->color->red($text);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, true);
    }

    /**
     * Write formatted text in HTML style
     * @see Color::colors
     *
     * @param string $text
     * @param bool $eol
     * @return $this
     */
    public function colors(string $text, bool $eol = false): self
    {
        $styledText = $this->color->colors($text);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the raw text to stream.
     * @param string $text
     * @param bool $error
     * @return $this
     */
    public function raw(string $text, bool $error = false): self
    {
        return $this->doWrite($text, $error);
    }

    /**
     * Generate table for the console
     * @param array<int, array<int, array<string, string>>> $rows
     * @param array<string, string> $styles
     * @return self
     */
    public function table(array $rows, array $styles = []): self
    {
        $table = (new Table())->render($rows, $styles);

        return $this->colors($table, true);
    }

    /**
     * Write EOL count times.
     * @param int $count
     * @return $this
     */
    public function eol(int $count = 1): self
    {
        return $this->doWrite(str_repeat(PHP_EOL, max($count, 1)), false);
    }

    /**
     * Magic call to handle dynamic color, style
     * @param string $method
     * @param array<int, mixed> $args
     * @return $this
     */
    public function __call(string $method, array $args = [])
    {
        if (method_exists($this->cursor, $method)) {
            return $this->cursor->{$method}(...$args);
        }

        $this->method = $method;

        return $this->write(...$args);
    }

    /**
     * Write to the standard output or standard error stream.
     * @param string $text
     * @param bool $error
     * @return $this
     */
    protected function doWrite(string $text, bool $error = false): self
    {
        $stream = $error ?
                $this->errorStream
                : $this->stream;

        fwrite($stream, $text);

        return $this;
    }
}
