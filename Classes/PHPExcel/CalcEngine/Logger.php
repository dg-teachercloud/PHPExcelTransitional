<?php

/**
 * PHPExcel_CalcEngine_Logger
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Calculation
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class PHPExcel_CalcEngine_Logger
{
    /**
     * Flag to determine whether a debug log should be generated by the calculation engine
     *        If true, then a debug log will be generated
     *        If false, then a debug log will not be generated
     *
     * @var boolean
     */
    private $writeDebugLog = false;

    /**
     * Flag to determine whether a debug log should be echoed by the calculation engine
     *        If true, then a debug log will be echoed
     *        If false, then a debug log will not be echoed
     * A debug log can only be echoed if it is generated
     *
     * @var boolean
     */
    private $echoDebugLog = false;

    /**
     * The debug log generated by the calculation engine
     *
     * @var string[]
     */
    private $debugLog = array();

    /**
     * The calculation engine cell reference stack
     *
     * @var PHPExcel_CalcEngine_CyclicReferenceStack
     */
    private $cellStack;

    /**
     * Instantiate a Calculation engine logger
     *
     * @param  PHPExcel_CalcEngine_CyclicReferenceStack $stack
     */
    public function __construct(PHPExcel_CalcEngine_CyclicReferenceStack $stack)
    {
        $this->cellStack = $stack;
    }

    /**
     * Enable/Disable Calculation engine logging
     *
     * @param  boolean $pValue
     */
    public function setWriteDebugLog($pValue = false)
    {
        $this->writeDebugLog = $pValue;
    }

    /**
     * Return whether calculation engine logging is enabled or disabled
     *
     * @return  boolean
     */
    public function getWriteDebugLog()
    {
        return $this->writeDebugLog;
    }

    /**
     * Enable/Disable echoing of debug log information
     *
     * @param  boolean $pValue
     */
    public function setEchoDebugLog($pValue = false)
    {
        $this->echoDebugLog = $pValue;
    }

    /**
     * Return whether echoing of debug log information is enabled or disabled
     *
     * @return  boolean
     */
    public function getEchoDebugLog()
    {
        return $this->echoDebugLog;
    }

    /**
     * Write an entry to the calculation engine debug log
     */
    public function writeDebugLog()
    {
        //    Only write the debug log if logging is enabled
        if ($this->writeDebugLog) {
            $message = implode("", func_get_args());
            $cellReference = implode(' -> ', $this->cellStack->showStack());
            if ($this->echoDebugLog) {
                echo $cellReference,
                    ($this->cellStack->count() > 0 ? ' => ' : ''),
                    $message,
                    PHP_EOL;
            }
            $this->debugLog[] = $cellReference .
                ($this->cellStack->count() > 0 ? ' => ' : '') .
                $message;
        }
    }

    /**
     * Clear the calculation engine debug log
     */
    public function clearLog()
    {
        $this->debugLog = array();
    }

    /**
     * Return the calculation engine debug log
     *
     * @return  string[]
     */
    public function getLog()
    {
        return $this->debugLog;
    }
}
