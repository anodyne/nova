<?php
/*
* Created on 2008 May 31
* by Martin Wernstahl <m4rw3r at gmail dot com>
*/
/*
* Copyright (c) 2008, Martin Wernstahl
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*     * Redistributions of source code must retain the above copyright
*       notice, this list of conditions and the following disclaimer.
*     * Redistributions in binary form must reproduce the above copyright
*       notice, this list of conditions and the following disclaimer in the
*       documentation and/or other materials provided with the distribution.
*     * The name of Martin Wernstahl may not be used to endorse or promote products
*       derived from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY Martin Wernstahl ``AS IS'' AND ANY
* EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
* DISCLAIMED. IN NO EVENT SHALL Martin Wernstahl BE LIABLE FOR ANY
* DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
* (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
* ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
* (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
* SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
if(!function_exists('YAYPARSER_parse')){
    /**
     * YAYParser - Parser function.
     *
     * @param $str The string to be processed
     *
     * @return An array which contains data built from the string
     */
    function YAYPARSER_parse($str){
        $ret = array();
        if(!strlen($str))
            return $ret;
        $num = preg_match_all(
            // ONE REGEX TO RULE THEM ALL
            '@(?:^|\n)([^\S\n]*)(?:((?:\?\s*)?(\S*)\s*(?:#.*)?(?:\n[^\S\n]*#[^\n]*)*(?:\n[^\S\n]*)?:(?:[^\S\n]*)?)|(-(?:[^\S\n]*)?))(?:(?:\&(\S*))(?:[^\S\n]*)?|(?:\*(\S*))(?:[^\S\n]*)?)?(?:((?:[^\|>\'"\n]*)?(?:\n(?:(?:(?:\1)(?:[^\n\S]+)[^\n]*)|(?:[^\n\S]*#[^\n]*)|(?:[^\n\S]*(?=\n))))+)|(?:(\||>).*\n((?:[^\n\S]*\n)*(?:(?:\1)([^\n\S]+)[^\n]*)(?:(?:\n(?:\1)(?:[^\n\S]+?)[^\n]*)|(?:\n[^\n\S]*(?=\n)))*))|(?:("|\')([\w\W]*?)\11)|(?:\{([\w\W]*?)\})|(?:\[([\w\W]*?)\])|(?:([^#\n\s][^#\n]*))?)(?:#[^\n]*)?@'
            ,$str,$matches,PREG_SET_ORDER);
        foreach($matches as $match){
            // value:
            $data = array();
            if(isset($match[9]) && strlen($match[9])){
                // multiline
                $s = explode("\n",$match[9]);
                $indent_len = strlen($match[1]) + strlen($match[10]);
                array_walk($s,'YAYPARSER_substr',$indent_len);
                array_walk($s,'YAYPARSER_trim');
                if($match[8] == '|'){    // "|" preserves newlines
                    $data = implode("\n",$s);
                }
                else{
                    $data = implode(' ',$s);
                }
            }
            elseif(isset($match[7]) && strlen($match[7])){
                // block
                if(isset($match[4]) && strlen($match[4]))
                    $match[7] = str_repeat(' ',strlen($match[4]) + strlen($match[1])) . $match[7];
                elseif(isset($match[2]) && strlen($match[2]))
                    $match[7] = str_repeat(' ',strlen($match[2]) + strlen($match[1])) . $match[7];
                $data = YAYPARSER_parse($match[7]);
            }
            elseif(isset($match[12]) && strlen($match[12])){
                // flow scalar
                $arr = explode("\n",$match[12]);
                array_walk($arr,'YAYPARSER_trim');
                $data = trim(implode("\n",$arr));
            }
            elseif(isset($match[13]) && strlen($match[13])){
                // flow node with key/value
                $list = explode(',',$match[13]);
                array_walk($list,'YAYPARSER_trim');
                foreach($list as $l){
                    $data = array_merge($data,(Array)YAYPARSER_parse($l));
                }
            }
            elseif(isset($match[14]) && strlen($match[14])){
                $data = explode(',',$match[14]);
                array_walk($data,'YAYPARSER_trim');
            }
            elseif(isset($match[15])){
                // value
                $data = $match[15];
            }
            // create anchor
            if(isset($match[5]) && strlen($match[5]))
                $GLOBALS['YAYPARSER_anchors'][$match[5]] = $data;
            // load anchor
            if(isset($match[6]) && strlen($match[6])){
                if(isset($GLOBALS['YAYPARSER_anchors'][$match[6]]))
                    $data = $GLOBALS['YAYPARSER_anchors'][$match[6]];
                else
                    log_message('warning','yayparser: The anchor '.$match[6].' was not found.');
            }
            // key / list saving
            if(isset($match[3]) && strlen($match[3])){
                $ret[$match[3]] = $data;
            }
            elseif(isset($match[4]) && strlen($match[4])){
                // list
                $ret[] = $data;
            }
        }
        if($num)
            return $ret;
        // a block without any tags/lists is regarded as a string (newline = space)
        $arr = explode("\n",$str);
        array_walk($arr,'YAYPARSER_trim');
        return trim(implode(' ',$arr));
    }
}
if(!function_exists('yayparser')){
    /**
     * YAYParser - Yet Anoter Yaml Parser.
     *
     * @param $str The string to be processed
     *
     * @return An array which contains data built from the string
     */
    function yayparser($str){
        if(!strlen($str))
            return array();
        $ret = array();
        // split the string into many documents according to the YAML standard
        preg_match_all('@(?:(?:^|\n)-{3}([\w\W]*?)(?:\n\.{3}(?:[\w\W]*?)(?=(?:\n-{3})|$))?(?=(?:\n-{3})|(?:$)))@',
                        "---\n".$str,        // make $str an explicit document by adding a --- in the beginning
                        $matches,PREG_SET_ORDER);
        foreach($matches as $match){
            $GLOBALS['YAYPARSER_anchors'] = array();
            if(isset($match[1]) && strlen(trim($match[1]))){
                if(count($data = YAYPARSER_parse($match[1])))
                    $ret[] = $data;
            }
        }
        if(count($ret) == 1)
            $ret = $ret[0];
        return $ret;
    }
}
if(!function_exists('YAYPARSER_substr')){
    /**
     * A substr wrapper for use with array_walk().
     */
    function YAYPARSER_substr(&$value,&$key,&$len){
        $value = substr($value,$len);
    }
}
if(!function_exists('YAYPARSER_trim')){
    /**
     * A trim wrapper for use with array_walk().
     */
    function YAYPARSER_trim(&$value,&$key){
        $value = trim($value);
    }
}
