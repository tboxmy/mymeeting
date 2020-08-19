<?php
/*
 * Copyright (c) 2008 Government of Malaysia
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 * @author: Abdullah Zainul Abidin, Nuhaa All Bakry
 *          Eavay Javay Barnad, Sarogini Muniyandi
 *
 */

class MultiFileBehavior extends ModelBehavior
{
    /**
     * Define $settings
     *
     */
    var $settings=array();
    /**
     * Define $runtime
     *
     */
    var $runtime=array();
    /**
     * Define $mfile
     *
     */
    var $mfile;

    /**
     * Describe __construct
     *
     * @return null
     */
    function __construct(){
        $this->mfile=ClassRegistry::init('Attachment','model');
    }

    /**
     * Describe afterFind
     *
     * @param $model
     * @param $results
     * @param $primary
     * @return null
     */
    public function afterFind(&$model,$results,$primary){
        if($model->recursive>0){
            if($primary && is_array($results)){
                foreach($results as &$result){
                    if(isset($result[$model->alias]) && isset($result[$model->alias][$model->primaryKey])){
                        $attachcond['Attachment.foreign_key']=$result[$model->alias][$model->primaryKey];
                        $attachcond['Attachment.model']=$model->alias;
                        $dattach=$this->mfile->findAll($attachcond);
                        foreach($dattach as $ddat){
                            $attach[$ddat['Attachment']['field']][]=$ddat;
                        }

                        if(!empty($attach)){
                            $result['MultiFile']=$attach;
                            unset($attach);
                        }
                    }
                }
            }
        }
        return $results;
    }

    /**
     * Describe unique_name
     *
     * @param $filename
     * @return null
     */
    private function unique_name($filename){
        if(!is_file($filename)){
            return $filename;
        }
        else{
            $dot=strrpos($filename,'.');
            if($dot===false) $dot=strlen($filename);

            //see how many digits is before the dot
            $curchar=substr($filename,$dot-1,1);
            $numofnum=0;
            while(is_numeric($curchar)){
                $numofnum++;
                $curchar=substr($filename,$dot-($numofnum+1),1);
            }

            if($numofnum){
                $curnum=substr($filename,$dot-($numofnum),$numofnum)+1;
            }
            else{
                $curnum=1;
            }
            return $this->unique_name(substr($filename,0,$dot-$numofnum).$curnum.substr($filename,$dot));
        }
    }

    /**
     * Describe beforeSave
     *
     * @param $model
     * @return null
     */
    public function beforeSave(&$model)
    {
        if(isset($_FILES)){
            $i=1;
            foreach($_FILES as $fname=>$fdat){
                $pecah=explode("_",$fname);
                if($pecah[0]=='Mfile' && !$fdat['error']){
                    $destination=$this->unique_name(WWW_ROOT.'upload'.DS.$fdat['name']);
                    if(move_uploaded_file($fdat['tmp_name'],$destination)){
                        $mfiledata['Attachment']['model']=$model->alias;
                        $mfiledata['Attachment']['file']=substr($destination,strlen(WWW_ROOT));
                        $mfiledata['Attachment']['filename']=$fdat['name'];
                        $mfiledata['Attachment']['field']=$pecah[1];
                        $mfiledata['Attachment']['type']=$fdat['type'];
                        $mfiledata['Attachment']['size']=$fdat['size'];
                        $this->mfile->create();
                        $this->mfile->save($mfiledata);
                        $this->runtime['Mfile_id'][]=$this->mfile->getLastInsertID();
                    }
                    else{
                        return false;
                    }
                }
            }
        }
        foreach($_POST as $pname=>$pdat){
            $pecah=explode("_",$pname);
            if(is_array($pecah) && $pecah[0]=='delold' && $pdat==1){
                $fdat=$this->mfile->find('first',array('conditions'=>array('id'=>$pecah[2],'field'=>$pecah[1])));
                if(is_file($fdat['Attachment']['file'])){
                    if(unlink($fdat['Attachment']['file'])){
                        $this->mfile->del($pecah[2]);
                    }
                }
                else{
                    $this->mfile->del($pecah[2]);
                }
            }
        }
        return true;
    }

    /**
     * Describe afterSave
     *
     * @param $model
     * @param $created
     * @return null
     */
    public function afterSave(&$model,$created){
        if($created){
            $foreign_key=$model->getLastInsertID();
        }
        else{
            $foreign_key=$model->id;
        }
        if(isset($this->runtime['Mfile_id'])){
            foreach($this->runtime['Mfile_id'] as $dfid){
                $this->mfile->id=$dfid;
                $this->mfile->data['Attachment']['foreign_key']=$foreign_key;
                $this->mfile->save();
            }
        }
    }
}

?>
