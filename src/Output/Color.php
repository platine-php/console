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
 *  @file Color.php
 *
 *  The Output Color class
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

use Error;

/**
 * @class Color
 * @package Platine\Console\Output
 *
 * @method string bold(string $text)
 * @method string dim(string $text)
 * @method string italic(string $text)
 * @method string underline(string $text)
 * @method string black(string $text)
 * @method string red(string $text)
 * @method string green(string $text)
 * @method string yellow(string $text)
 * @method string blue(string $text)
 * @method string purple(string $text)
 * @method string cyan(string $text)
 * @method string white(string $text)
 * @method string gray(string $text)
 * @method string darkgray(string $text)
 * @method string bgBlack(string $text)
 * @method string bgRed(string $text)
 * @method string bgGreen(string $text)
 * @method string bgYellow(string $text)
 * @method string bgBlue(string $text)
 * @method string bgPurple(string $text)
 * @method string bgCyan(string $text)
 * @method string bgWhite(string $text)
 * @method string bgGray(string $text)
 * @method string bgDarkgray(string $text)
 * @method string boldBlack(string $text)
 * @method string boldRed(string $text)
 * @method string boldGreen(string $text)
 * @method string boldYellow(string $text)
 * @method string boldBlue(string $text)
 * @method string boldPurple(string $text)
 * @method string boldCyan(string $text)
 * @method string boldWhite(string $text)
 * @method string boldGray(string $text)
 * @method string boldDarkgray(string $text)
 * @method string dimBlack(string $text)
 * @method string dimRed(string $text)
 * @method string dimGreen(string $text)
 * @method string dimYellow(string $text)
 * @method string dimBlue(string $text)
 * @method string dimPurple(string $text)
 * @method string dimCyan(string $text)
 * @method string dimWhite(string $text)
 * @method string dimGray(string $text)
 * @method string dimDarkgray(string $text)
 * @method string italicBlack(string $text)
 * @method string italicRed(string $text)
 * @method string italicGreen(string $text)
 * @method string italicYellow(string $text)
 * @method string italicBlue(string $text)
 * @method string italicPurple(string $text)
 * @method string italicCyan(string $text)
 * @method string italicWhite(string $text)
 * @method string italicGray(string $text)
 * @method string italicDarkgray(string $text)
 * @method string underlineBlack(string $text)
 * @method string underlineRed(string $text)
 * @method string underlineGreen(string $text)
 * @method string underlineYellow(string $text)
 * @method string underlineBlue(string $text)
 * @method string underlinePurple(string $text)
 * @method string underlineCyan(string $text)
 * @method string underlineWhite(string $text)
 * @method string underlineGray(string $text)
 * @method string underlineDarkgray(string $text)
 * @method string boldBgBlack(string $text)
 * @method string boldBgRed(string $text)
 * @method string boldBgGreen(string $text)
 * @method string boldBgYellow(string $text)
 * @method string boldBgBlue(string $text)
 * @method string boldBgPurple(string $text)
 * @method string boldBgCyan(string $text)
 * @method string boldBgWhite(string $text)
 * @method string boldBgGray(string $text)
 * @method string boldBgDarkgray(string $text)
 * @method string dimBgBlack(string $text)
 * @method string dimBgRed(string $text)
 * @method string dimBgGreen(string $text)
 * @method string dimBgYellow(string $text)
 * @method string dimBgBlue(string $text)
 * @method string dimBgPurple(string $text)
 * @method string dimBgCyan(string $text)
 * @method string dimBgWhite(string $text)
 * @method string dimBgGray(string $text)
 * @method string dimBgDarkgray(string $text)
 * @method string italicBgBlack(string $text)
 * @method string italicBgRed(string $text)
 * @method string italicBgGreen(string $text)
 * @method string italicBgYellow(string $text)
 * @method string italicBgBlue(string $text)
 * @method string italicBgPurple(string $text)
 * @method string italicBgCyan(string $text)
 * @method string italicBgWhite(string $text)
 * @method string italicBgGray(string $text)
 * @method string italicBgDarkgray(string $text)
 * @method string underlineBgBlack(string $text)
 * @method string underlineBgRed(string $text)
 * @method string underlineBgGreen(string $text)
 * @method string underlineBgYellow(string $text)
 * @method string underlineBgBlue(string $text)
 * @method string underlineBgPurple(string $text)
 * @method string underlineBgCyan(string $text)
 * @method string underlineBgWhite(string $text)
 * @method string underlineBgGray(string $text)
 * @method string underlineBgDarkgray(string $text)
 * @method string boldBlackBgRed(string $text)
 * @method string boldBlackBgGreen(string $text)
 * @method string boldBlackBgYellow(string $text)
 * @method string boldBlackBgBlue(string $text)
 * @method string boldBlackBgPurple(string $text)
 * @method string boldBlackBgCyan(string $text)
 * @method string boldBlackBgWhite(string $text)
 * @method string boldBlackBgGray(string $text)
 * @method string boldBlackBgDarkgray(string $text)
 * @method string boldRedBgBlack(string $text)
 * @method string boldRedBgGreen(string $text)
 * @method string boldRedBgYellow(string $text)
 * @method string boldRedBgBlue(string $text)
 * @method string boldRedBgPurple(string $text)
 * @method string boldRedBgCyan(string $text)
 * @method string boldRedBgWhite(string $text)
 * @method string boldRedBgGray(string $text)
 * @method string boldRedBgDarkgray(string $text)
 * @method string boldGreenBgBlack(string $text)
 * @method string boldGreenBgRed(string $text)
 * @method string boldGreenBgYellow(string $text)
 * @method string boldGreenBgBlue(string $text)
 * @method string boldGreenBgPurple(string $text)
 * @method string boldGreenBgCyan(string $text)
 * @method string boldGreenBgWhite(string $text)
 * @method string boldGreenBgGray(string $text)
 * @method string boldGreenBgDarkgray(string $text)
 * @method string boldYellowBgBlack(string $text)
 * @method string boldYellowBgRed(string $text)
 * @method string boldYellowBgGreen(string $text)
 * @method string boldYellowBgBlue(string $text)
 * @method string boldYellowBgPurple(string $text)
 * @method string boldYellowBgCyan(string $text)
 * @method string boldYellowBgWhite(string $text)
 * @method string boldYellowBgGray(string $text)
 * @method string boldYellowBgDarkgray(string $text)
 * @method string boldBlueBgBlack(string $text)
 * @method string boldBlueBgRed(string $text)
 * @method string boldBlueBgGreen(string $text)
 * @method string boldBlueBgYellow(string $text)
 * @method string boldBlueBgPurple(string $text)
 * @method string boldBlueBgCyan(string $text)
 * @method string boldBlueBgWhite(string $text)
 * @method string boldBlueBgGray(string $text)
 * @method string boldBlueBgDarkgray(string $text)
 * @method string boldPurpleBgBlack(string $text)
 * @method string boldPurpleBgRed(string $text)
 * @method string boldPurpleBgGreen(string $text)
 * @method string boldPurpleBgYellow(string $text)
 * @method string boldPurpleBgBlue(string $text)
 * @method string boldPurpleBgCyan(string $text)
 * @method string boldPurpleBgWhite(string $text)
 * @method string boldPurpleBgGray(string $text)
 * @method string boldPurpleBgDarkgray(string $text)
 * @method string boldCyanBgBlack(string $text)
 * @method string boldCyanBgRed(string $text)
 * @method string boldCyanBgGreen(string $text)
 * @method string boldCyanBgYellow(string $text)
 * @method string boldCyanBgBlue(string $text)
 * @method string boldCyanBgPurple(string $text)
 * @method string boldCyanBgWhite(string $text)
 * @method string boldCyanBgGray(string $text)
 * @method string boldCyanBgDarkgray(string $text)
 * @method string boldWhiteBgBlack(string $text)
 * @method string boldWhiteBgRed(string $text)
 * @method string boldWhiteBgGreen(string $text)
 * @method string boldWhiteBgYellow(string $text)
 * @method string boldWhiteBgBlue(string $text)
 * @method string boldWhiteBgPurple(string $text)
 * @method string boldWhiteBgCyan(string $text)
 * @method string boldWhiteBgGray(string $text)
 * @method string boldWhiteBgDarkgray(string $text)
 * @method string boldGrayBgBlack(string $text)
 * @method string boldGrayBgRed(string $text)
 * @method string boldGrayBgGreen(string $text)
 * @method string boldGrayBgYellow(string $text)
 * @method string boldGrayBgBlue(string $text)
 * @method string boldGrayBgPurple(string $text)
 * @method string boldGrayBgCyan(string $text)
 * @method string boldGrayBgWhite(string $text)
 * @method string boldGrayBgDarkgray(string $text)
 * @method string boldDarkgrayBgBlack(string $text)
 * @method string boldDarkgrayBgRed(string $text)
 * @method string boldDarkgrayBgGreen(string $text)
 * @method string boldDarkgrayBgYellow(string $text)
 * @method string boldDarkgrayBgBlue(string $text)
 * @method string boldDarkgrayBgPurple(string $text)
 * @method string boldDarkgrayBgCyan(string $text)
 * @method string boldDarkgrayBgWhite(string $text)
 * @method string boldDarkgrayBgGray(string $text)
 * @method string dimBlackBgRed(string $text)
 * @method string dimBlackBgGreen(string $text)
 * @method string dimBlackBgYellow(string $text)
 * @method string dimBlackBgBlue(string $text)
 * @method string dimBlackBgPurple(string $text)
 * @method string dimBlackBgCyan(string $text)
 * @method string dimBlackBgWhite(string $text)
 * @method string dimBlackBgGray(string $text)
 * @method string dimBlackBgDarkgray(string $text)
 * @method string dimRedBgBlack(string $text)
 * @method string dimRedBgGreen(string $text)
 * @method string dimRedBgYellow(string $text)
 * @method string dimRedBgBlue(string $text)
 * @method string dimRedBgPurple(string $text)
 * @method string dimRedBgCyan(string $text)
 * @method string dimRedBgWhite(string $text)
 * @method string dimRedBgGray(string $text)
 * @method string dimRedBgDarkgray(string $text)
 * @method string dimGreenBgBlack(string $text)
 * @method string dimGreenBgRed(string $text)
 * @method string dimGreenBgYellow(string $text)
 * @method string dimGreenBgBlue(string $text)
 * @method string dimGreenBgPurple(string $text)
 * @method string dimGreenBgCyan(string $text)
 * @method string dimGreenBgWhite(string $text)
 * @method string dimGreenBgGray(string $text)
 * @method string dimGreenBgDarkgray(string $text)
 * @method string dimYellowBgBlack(string $text)
 * @method string dimYellowBgRed(string $text)
 * @method string dimYellowBgGreen(string $text)
 * @method string dimYellowBgBlue(string $text)
 * @method string dimYellowBgPurple(string $text)
 * @method string dimYellowBgCyan(string $text)
 * @method string dimYellowBgWhite(string $text)
 * @method string dimYellowBgGray(string $text)
 * @method string dimYellowBgDarkgray(string $text)
 * @method string dimBlueBgBlack(string $text)
 * @method string dimBlueBgRed(string $text)
 * @method string dimBlueBgGreen(string $text)
 * @method string dimBlueBgYellow(string $text)
 * @method string dimBlueBgPurple(string $text)
 * @method string dimBlueBgCyan(string $text)
 * @method string dimBlueBgWhite(string $text)
 * @method string dimBlueBgGray(string $text)
 * @method string dimBlueBgDarkgray(string $text)
 * @method string dimPurpleBgBlack(string $text)
 * @method string dimPurpleBgRed(string $text)
 * @method string dimPurpleBgGreen(string $text)
 * @method string dimPurpleBgYellow(string $text)
 * @method string dimPurpleBgBlue(string $text)
 * @method string dimPurpleBgCyan(string $text)
 * @method string dimPurpleBgWhite(string $text)
 * @method string dimPurpleBgGray(string $text)
 * @method string dimPurpleBgDarkgray(string $text)
 * @method string dimCyanBgBlack(string $text)
 * @method string dimCyanBgRed(string $text)
 * @method string dimCyanBgGreen(string $text)
 * @method string dimCyanBgYellow(string $text)
 * @method string dimCyanBgBlue(string $text)
 * @method string dimCyanBgPurple(string $text)
 * @method string dimCyanBgWhite(string $text)
 * @method string dimCyanBgGray(string $text)
 * @method string dimCyanBgDarkgray(string $text)
 * @method string dimWhiteBgBlack(string $text)
 * @method string dimWhiteBgRed(string $text)
 * @method string dimWhiteBgGreen(string $text)
 * @method string dimWhiteBgYellow(string $text)
 * @method string dimWhiteBgBlue(string $text)
 * @method string dimWhiteBgPurple(string $text)
 * @method string dimWhiteBgCyan(string $text)
 * @method string dimWhiteBgGray(string $text)
 * @method string dimWhiteBgDarkgray(string $text)
 * @method string dimGrayBgBlack(string $text)
 * @method string dimGrayBgRed(string $text)
 * @method string dimGrayBgGreen(string $text)
 * @method string dimGrayBgYellow(string $text)
 * @method string dimGrayBgBlue(string $text)
 * @method string dimGrayBgPurple(string $text)
 * @method string dimGrayBgCyan(string $text)
 * @method string dimGrayBgWhite(string $text)
 * @method string dimGrayBgDarkgray(string $text)
 * @method string dimDarkgrayBgBlack(string $text)
 * @method string dimDarkgrayBgRed(string $text)
 * @method string dimDarkgrayBgGreen(string $text)
 * @method string dimDarkgrayBgYellow(string $text)
 * @method string dimDarkgrayBgBlue(string $text)
 * @method string dimDarkgrayBgPurple(string $text)
 * @method string dimDarkgrayBgCyan(string $text)
 * @method string dimDarkgrayBgWhite(string $text)
 * @method string dimDarkgrayBgGray(string $text)
 * @method string italicBlackBgRed(string $text)
 * @method string italicBlackBgGreen(string $text)
 * @method string italicBlackBgYellow(string $text)
 * @method string italicBlackBgBlue(string $text)
 * @method string italicBlackBgPurple(string $text)
 * @method string italicBlackBgCyan(string $text)
 * @method string italicBlackBgWhite(string $text)
 * @method string italicBlackBgGray(string $text)
 * @method string italicBlackBgDarkgray(string $text)
 * @method string italicRedBgBlack(string $text)
 * @method string italicRedBgGreen(string $text)
 * @method string italicRedBgYellow(string $text)
 * @method string italicRedBgBlue(string $text)
 * @method string italicRedBgPurple(string $text)
 * @method string italicRedBgCyan(string $text)
 * @method string italicRedBgWhite(string $text)
 * @method string italicRedBgGray(string $text)
 * @method string italicRedBgDarkgray(string $text)
 * @method string italicGreenBgBlack(string $text)
 * @method string italicGreenBgRed(string $text)
 * @method string italicGreenBgYellow(string $text)
 * @method string italicGreenBgBlue(string $text)
 * @method string italicGreenBgPurple(string $text)
 * @method string italicGreenBgCyan(string $text)
 * @method string italicGreenBgWhite(string $text)
 * @method string italicGreenBgGray(string $text)
 * @method string italicGreenBgDarkgray(string $text)
 * @method string italicYellowBgBlack(string $text)
 * @method string italicYellowBgRed(string $text)
 * @method string italicYellowBgGreen(string $text)
 * @method string italicYellowBgBlue(string $text)
 * @method string italicYellowBgPurple(string $text)
 * @method string italicYellowBgCyan(string $text)
 * @method string italicYellowBgWhite(string $text)
 * @method string italicYellowBgGray(string $text)
 * @method string italicYellowBgDarkgray(string $text)
 * @method string italicBlueBgBlack(string $text)
 * @method string italicBlueBgRed(string $text)
 * @method string italicBlueBgGreen(string $text)
 * @method string italicBlueBgYellow(string $text)
 * @method string italicBlueBgPurple(string $text)
 * @method string italicBlueBgCyan(string $text)
 * @method string italicBlueBgWhite(string $text)
 * @method string italicBlueBgGray(string $text)
 * @method string italicBlueBgDarkgray(string $text)
 * @method string italicPurpleBgBlack(string $text)
 * @method string italicPurpleBgRed(string $text)
 * @method string italicPurpleBgGreen(string $text)
 * @method string italicPurpleBgYellow(string $text)
 * @method string italicPurpleBgBlue(string $text)
 * @method string italicPurpleBgCyan(string $text)
 * @method string italicPurpleBgWhite(string $text)
 * @method string italicPurpleBgGray(string $text)
 * @method string italicPurpleBgDarkgray(string $text)
 * @method string italicCyanBgBlack(string $text)
 * @method string italicCyanBgRed(string $text)
 * @method string italicCyanBgGreen(string $text)
 * @method string italicCyanBgYellow(string $text)
 * @method string italicCyanBgBlue(string $text)
 * @method string italicCyanBgPurple(string $text)
 * @method string italicCyanBgWhite(string $text)
 * @method string italicCyanBgGray(string $text)
 * @method string italicCyanBgDarkgray(string $text)
 * @method string italicWhiteBgBlack(string $text)
 * @method string italicWhiteBgRed(string $text)
 * @method string italicWhiteBgGreen(string $text)
 * @method string italicWhiteBgYellow(string $text)
 * @method string italicWhiteBgBlue(string $text)
 * @method string italicWhiteBgPurple(string $text)
 * @method string italicWhiteBgCyan(string $text)
 * @method string italicWhiteBgGray(string $text)
 * @method string italicWhiteBgDarkgray(string $text)
 * @method string italicGrayBgBlack(string $text)
 * @method string italicGrayBgRed(string $text)
 * @method string italicGrayBgGreen(string $text)
 * @method string italicGrayBgYellow(string $text)
 * @method string italicGrayBgBlue(string $text)
 * @method string italicGrayBgPurple(string $text)
 * @method string italicGrayBgCyan(string $text)
 * @method string italicGrayBgWhite(string $text)
 * @method string italicGrayBgDarkgray(string $text)
 * @method string italicDarkgrayBgBlack(string $text)
 * @method string italicDarkgrayBgRed(string $text)
 * @method string italicDarkgrayBgGreen(string $text)
 * @method string italicDarkgrayBgYellow(string $text)
 * @method string italicDarkgrayBgBlue(string $text)
 * @method string italicDarkgrayBgPurple(string $text)
 * @method string italicDarkgrayBgCyan(string $text)
 * @method string italicDarkgrayBgWhite(string $text)
 * @method string italicDarkgrayBgGray(string $text)
 * @method string underlineBlackBgRed(string $text)
 * @method string underlineBlackBgGreen(string $text)
 * @method string underlineBlackBgYellow(string $text)
 * @method string underlineBlackBgBlue(string $text)
 * @method string underlineBlackBgPurple(string $text)
 * @method string underlineBlackBgCyan(string $text)
 * @method string underlineBlackBgWhite(string $text)
 * @method string underlineBlackBgGray(string $text)
 * @method string underlineBlackBgDarkgray(string $text)
 * @method string underlineRedBgBlack(string $text)
 * @method string underlineRedBgGreen(string $text)
 * @method string underlineRedBgYellow(string $text)
 * @method string underlineRedBgBlue(string $text)
 * @method string underlineRedBgPurple(string $text)
 * @method string underlineRedBgCyan(string $text)
 * @method string underlineRedBgWhite(string $text)
 * @method string underlineRedBgGray(string $text)
 * @method string underlineRedBgDarkgray(string $text)
 * @method string underlineGreenBgBlack(string $text)
 * @method string underlineGreenBgRed(string $text)
 * @method string underlineGreenBgYellow(string $text)
 * @method string underlineGreenBgBlue(string $text)
 * @method string underlineGreenBgPurple(string $text)
 * @method string underlineGreenBgCyan(string $text)
 * @method string underlineGreenBgWhite(string $text)
 * @method string underlineGreenBgGray(string $text)
 * @method string underlineGreenBgDarkgray(string $text)
 * @method string underlineYellowBgBlack(string $text)
 * @method string underlineYellowBgRed(string $text)
 * @method string underlineYellowBgGreen(string $text)
 * @method string underlineYellowBgBlue(string $text)
 * @method string underlineYellowBgPurple(string $text)
 * @method string underlineYellowBgCyan(string $text)
 * @method string underlineYellowBgWhite(string $text)
 * @method string underlineYellowBgGray(string $text)
 * @method string underlineYellowBgDarkgray(string $text)
 * @method string underlineBlueBgBlack(string $text)
 * @method string underlineBlueBgRed(string $text)
 * @method string underlineBlueBgGreen(string $text)
 * @method string underlineBlueBgYellow(string $text)
 * @method string underlineBlueBgPurple(string $text)
 * @method string underlineBlueBgCyan(string $text)
 * @method string underlineBlueBgWhite(string $text)
 * @method string underlineBlueBgGray(string $text)
 * @method string underlineBlueBgDarkgray(string $text)
 * @method string underlinePurpleBgBlack(string $text)
 * @method string underlinePurpleBgRed(string $text)
 * @method string underlinePurpleBgGreen(string $text)
 * @method string underlinePurpleBgYellow(string $text)
 * @method string underlinePurpleBgBlue(string $text)
 * @method string underlinePurpleBgCyan(string $text)
 * @method string underlinePurpleBgWhite(string $text)
 * @method string underlinePurpleBgGray(string $text)
 * @method string underlinePurpleBgDarkgray(string $text)
 * @method string underlineCyanBgBlack(string $text)
 * @method string underlineCyanBgRed(string $text)
 * @method string underlineCyanBgGreen(string $text)
 * @method string underlineCyanBgYellow(string $text)
 * @method string underlineCyanBgBlue(string $text)
 * @method string underlineCyanBgPurple(string $text)
 * @method string underlineCyanBgWhite(string $text)
 * @method string underlineCyanBgGray(string $text)
 * @method string underlineCyanBgDarkgray(string $text)
 * @method string underlineWhiteBgBlack(string $text)
 * @method string underlineWhiteBgRed(string $text)
 * @method string underlineWhiteBgGreen(string $text)
 * @method string underlineWhiteBgYellow(string $text)
 * @method string underlineWhiteBgBlue(string $text)
 * @method string underlineWhiteBgPurple(string $text)
 * @method string underlineWhiteBgCyan(string $text)
 * @method string underlineWhiteBgGray(string $text)
 * @method string underlineWhiteBgDarkgray(string $text)
 * @method string underlineGrayBgBlack(string $text)
 * @method string underlineGrayBgRed(string $text)
 * @method string underlineGrayBgGreen(string $text)
 * @method string underlineGrayBgYellow(string $text)
 * @method string underlineGrayBgBlue(string $text)
 * @method string underlineGrayBgPurple(string $text)
 * @method string underlineGrayBgCyan(string $text)
 * @method string underlineGrayBgWhite(string $text)
 * @method string underlineGrayBgDarkgray(string $text)
 * @method string underlineDarkgrayBgBlack(string $text)
 * @method string underlineDarkgrayBgRed(string $text)
 * @method string underlineDarkgrayBgGreen(string $text)
 * @method string underlineDarkgrayBgYellow(string $text)
 * @method string underlineDarkgrayBgBlue(string $text)
 * @method string underlineDarkgrayBgPurple(string $text)
 * @method string underlineDarkgrayBgCyan(string $text)
 * @method string underlineDarkgrayBgWhite(string $text)
 * @method string underlineDarkgrayBgGray(string $text)
 * @method string blackBgRed(string $text)
 * @method string blackBgGreen(string $text)
 * @method string blackBgYellow(string $text)
 * @method string blackBgBlue(string $text)
 * @method string blackBgPurple(string $text)
 * @method string blackBgCyan(string $text)
 * @method string blackBgWhite(string $text)
 * @method string blackBgGray(string $text)
 * @method string blackBgDarkgray(string $text)
 * @method string redBgBlack(string $text)
 * @method string redBgGreen(string $text)
 * @method string redBgYellow(string $text)
 * @method string redBgBlue(string $text)
 * @method string redBgPurple(string $text)
 * @method string redBgCyan(string $text)
 * @method string redBgWhite(string $text)
 * @method string redBgGray(string $text)
 * @method string redBgDarkgray(string $text)
 * @method string greenBgBlack(string $text)
 * @method string greenBgRed(string $text)
 * @method string greenBgYellow(string $text)
 * @method string greenBgBlue(string $text)
 * @method string greenBgPurple(string $text)
 * @method string greenBgCyan(string $text)
 * @method string greenBgWhite(string $text)
 * @method string greenBgGray(string $text)
 * @method string greenBgDarkgray(string $text)
 * @method string yellowBgBlack(string $text)
 * @method string yellowBgRed(string $text)
 * @method string yellowBgGreen(string $text)
 * @method string yellowBgBlue(string $text)
 * @method string yellowBgPurple(string $text)
 * @method string yellowBgCyan(string $text)
 * @method string yellowBgWhite(string $text)
 * @method string yellowBgGray(string $text)
 * @method string yellowBgDarkgray(string $text)
 * @method string blueBgBlack(string $text)
 * @method string blueBgRed(string $text)
 * @method string blueBgGreen(string $text)
 * @method string blueBgYellow(string $text)
 * @method string blueBgPurple(string $text)
 * @method string blueBgCyan(string $text)
 * @method string blueBgWhite(string $text)
 * @method string blueBgGray(string $text)
 * @method string blueBgDarkgray(string $text)
 * @method string purpleBgBlack(string $text)
 * @method string purpleBgRed(string $text)
 * @method string purpleBgGreen(string $text)
 * @method string purpleBgYellow(string $text)
 * @method string purpleBgBlue(string $text)
 * @method string purpleBgCyan(string $text)
 * @method string purpleBgWhite(string $text)
 * @method string purpleBgGray(string $text)
 * @method string purpleBgDarkgray(string $text)
 * @method string cyanBgBlack(string $text)
 * @method string cyanBgRed(string $text)
 * @method string cyanBgGreen(string $text)
 * @method string cyanBgYellow(string $text)
 * @method string cyanBgBlue(string $text)
 * @method string cyanBgPurple(string $text)
 * @method string cyanBgWhite(string $text)
 * @method string cyanBgGray(string $text)
 * @method string cyanBgDarkgray(string $text)
 * @method string whiteBgBlack(string $text)
 * @method string whiteBgRed(string $text)
 * @method string whiteBgGreen(string $text)
 * @method string whiteBgYellow(string $text)
 * @method string whiteBgBlue(string $text)
 * @method string whiteBgPurple(string $text)
 * @method string whiteBgCyan(string $text)
 * @method string whiteBgGray(string $text)
 * @method string whiteBgDarkgray(string $text)
 * @method string grayBgBlack(string $text)
 * @method string grayBgRed(string $text)
 * @method string grayBgGreen(string $text)
 * @method string grayBgYellow(string $text)
 * @method string grayBgBlue(string $text)
 * @method string grayBgPurple(string $text)
 * @method string grayBgCyan(string $text)
 * @method string grayBgWhite(string $text)
 * @method string grayBgDarkgray(string $text)
 * @method string darkgrayBgBlack(string $text)
 * @method string darkgrayBgRed(string $text)
 * @method string darkgrayBgGreen(string $text)
 * @method string darkgrayBgYellow(string $text)
 * @method string darkgrayBgBlue(string $text)
 * @method string darkgrayBgPurple(string $text)
 * @method string darkgrayBgCyan(string $text)
 * @method string darkgrayBgWhite(string $text)
 * @method string darkgrayBgGray(string $text)
*/
class Color
{
    /**
     * The color constants
     */
    public const BLACK    = 30;
    public const RED      = 31;
    public const GREEN    = 32;
    public const YELLOW   = 33;
    public const BLUE     = 34;
    public const PURPLE   = 35;
    public const CYAN     = 36;
    public const WHITE    = 37;
    public const GRAY     = 47;
    public const DARKGRAY = 100;

    /**
     * The style constants
     */
    public const BOLD = 1;
    public const DIM = 2;
    public const ITALIC = 3;
    public const UNDERLINE = 4;

    /**
     * The console color style format
     * @var string
     */
    protected string $format = "\033[:mod:;:fg:;:bg:m:txt:\033[0m";

    /**
     * Returns a line formatted as comment.
     * @param string $text
     * @return string
     */
    public function comment(string $text): string
    {
        return $this->line($text, null, null, self::DIM);
    }

    /**
     * Returns a line formatted as error.
     * @param string $text
     * @return string
     */
    public function error(string $text): string
    {
        return $this->red($text);
    }

    /**
     * Returns a line formatted ok error.
     * @param string $text
     * @return string
     */
    public function ok(string $text): string
    {
        return $this->green($text);
    }

    /**
     * Returns a line formatted as warning.
     * @param string $text
     * @return string
     */
    public function warn(string $text): string
    {
        return $this->yellow($text);
    }

    /**
     * Returns a line formatted as information.
     * @param string $text
     * @return string
     */
    public function info(string $text): string
    {
        return $this->blue($text);
    }

    /**
     * Returns a formatted/colored line.
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function line(
        string $text,
        ?int $fg = self::WHITE,
        ?int $bg = null,
        ?int $mode = null
    ): string {
        $style = [
            'bg' => $bg,
            'fg' => $fg === null ? self::WHITE : $fg,
            'mod' => $mode,
        ];

        $format = $style['bg'] === null
                ? str_replace(';:bg:', '', $this->format)
                : $this->format;

        $line = strtr($format, [
            ':mod:' => (int) $style['mod'],
            ':fg:' => $style['fg'],
            ':bg:' => $style['bg'],
            ':txt:' => $text
        ]);

        return $line;
    }

    /**
     * Prepare a multi colored string with HTML like tags.
     * Example: "<errorBold>Text</end><eol/><bgGreenBold>Text</end><eol>"
     * @param string $text
     * @return string
     */
    public function colors(string $text): string
    {
        $rawText = str_replace(
            [
                '</eol>',
                "\r\n",
                "\n"
            ],
            '__PHP_EOL__',
            $text
        );

        $matches = [];

        if (!preg_match_all('/<(\w+)>(.*?)<\/end>/', $rawText, $matches)) {
            return str_replace('__PHP_EOL__', PHP_EOL, $rawText);
        }

        $end = "\033[0m";
        $styledText = str_replace(['</end>'], $end, $rawText);

        foreach ($matches[1] as $method) {
            $part = str_replace($end, '', $this->{$method}(''));
            $styledText = str_replace('<' . $method . '>', $part, $styledText);
        }

        return str_replace('__PHP_EOL__', PHP_EOL, $styledText);
    }

    /**
     * Magic call to handle dynamic color, style
     * @param string $method
     * @param array<int, mixed> $args
     * @return string
     * @throws Error
     */
    public function __call(string $method, array $args = []): string
    {
        $colors = [
            'black' => self::BLACK,
            'red' => self::RED,
            'green' => self::GREEN,
            'yellow' => self::YELLOW,
            'blue' => self::BLUE,
            'purple' => self::PURPLE,
            'cyan' => self::CYAN,
            'white' => self::WHITE,
            'gray' => self::GRAY,
            'darkgray' => self::DARKGRAY
        ];

        $modes = [
            'bold' => self::BOLD,
            'dim' =>  self::DIM,
            'italic' => self::ITALIC,
            'underline' => self::UNDERLINE,
        ];

        $fg = null;
        $bg = null;
        $mode = null;

        $matches = [];

        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $method, $matches);

        if (count($matches[1]) > 0 && count($args) > 0) {
            $values = $matches[1];
            $count = count($values);

            for ($i = 0; $i < $count; $i++) {
                $val = strtolower($values[$i]);
                //color
                if (array_key_exists($val, $colors)) {
                    $fg = $colors[$val];
                }

                //modes
                if (array_key_exists($val, $modes)) {
                    $mode = $modes[$val];
                }

                //background colors
                if (
                    $val === 'bg'
                    && isset($values[$i + 1])
                    && array_key_exists(strtolower($values[$i + 1]), $colors)
                ) {
                    $val = strtolower($values[$i + 1]);
                    $bg = $colors[$val] + 10;
                    $i += 2;
                }
            }

            return $this->line($args[0], $fg, $bg, $mode);
        }

        throw new Error(sprintf('No such method [%s]', $method));
    }
}
