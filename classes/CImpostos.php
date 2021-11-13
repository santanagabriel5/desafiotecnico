<?php

class Courses{
//  Atributos
    private $id;
    private $nameCourse;
    private $description;
    private $dateStart;
    private $dateFinish;
    private $status;
    private $created_at;
    private $updated_at;
    
//  Geters e Seters  
    function getId() {
        return $this->id;
    }

    function getNameCourse() {
        return $this->nameCourse;
    }

    function getDescription() {
        return $this->description;
    }

    function getDateStart() {
        return $this->dateStart;
    }

    function getDateFinish() {
        return $this->dateFinish;
    }

    function getStatus() {
        return $this->status;
    }

    function getCreated_at() {
        return $this->created_at;
    }

    function getUpdated_at() {
        return $this->updated_at;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNameCourse($nameCourse) {
        $this->nameCourse = $nameCourse;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDateStart($dateStart) {
        $this->dateStart = $dateStart;
    }

    function setDateFinish($dateFinish) {
        $this->dateFinish = $dateFinish;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreated_at($created_at) {
        $this->created_at = $created_at;
    }

    function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at;
    }

    function instanciaCurso($id = null, $nameCourse = null, $description = null, $dateStart = null, $dateFinish = null, $status = null, $created_at = null, $updated_at = null) {
        $this->id = $id;
        $this->nameCourse = $nameCourse;
        $this->description = $description;
        $this->dateStart = $dateStart;
        $this->dateFinish = $dateFinish;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    
    function select($mysqli,$id=0,$where=null){
        $coursesQuery = "
                    SELECT
                            *                        
                        FROM
                            courses 
                        WHERE
                            0=0
                ";
        
        if($id!=0){
            $coursesQuery.= "
                                and Id=".$id;"
                ";
            $coursesQuery.= $where;       
            $coursesExe = $mysqli->query($coursesQuery);
            $coursesLinha = mysqli_fetch_array($coursesExe);
            $this->instanciaCurso(
                                        $coursesLinha['id'],
                                        $coursesLinha['nameCourse'],
                                        $coursesLinha['description'],
                                        $coursesLinha['dateStart'],
                                        $coursesLinha['dateFinish'],
                                        $coursesLinha['status'],
                                        $coursesLinha['created_at'],
                                        $coursesLinha['updated_at']
                                    );
//            print_r($this->getId());
            return $this;
        }else{
            $coursesQuery.= $where;
            $coursesExe = $mysqli->query($coursesQuery);
            $arrCourses = array();
            while($coursesLinha = mysqli_fetch_array($coursesExe)){
                $instanciaCourse = new Courses;
//                print_r($coursesLinha);
                $instanciaCourse->instanciaCurso(
                                        $coursesLinha['id'],
                                        $coursesLinha['nameCourse'],
                                        $coursesLinha['description'],
                                        $coursesLinha['dateStart'],
                                        $coursesLinha['dateFinish'],
                                        $coursesLinha['status'],
                                        $coursesLinha['created_at'],
                                        $coursesLinha['updated_at']
                                    );
                
                $arrCourses[]=$instanciaCourse;
            }
            return $arrCourses;
        }
    }
    
    function update($mysqli){
        $sqlUpdateCurso="
            UPDATE  courses
                SET 
                    nameCourse = '".$this->nameCourse."',
                    description = '".$this->description."',
                    dateStart = '".$this->dateStart."',
                    dateFinish = '".$this->dateFinish."',
                    status = '".$this->status."',
                    updated_at = CURRENT_TIMESTAMP()
                WHERE 
                    id = '".$this->id."';
            ";
        
//        echo $sqlUpdateCurso;
        $mysqli->query($sqlUpdateCurso);
    }
    
    function insert($mysqli){
        $sqlInsertCurso="
                INSERT
                    INTO
                        courses
                                (
                                    nameCourse,
                                    description,
                                    dateStart,
                                    dateFinish,
                                    status,
                                    created_at
                                )VALUES(
                                    '".$this->nameCourse."',
                                    '".$this->description."',
                                    '".$this->dateStart."',
                                    '".$this->dateFinish."',
                                    '".$this->status."',
                                    CURRENT_TIMESTAMP()
                                );
            ";
//        echo $sqlInsertCurso;
        $mysqli->query($sqlInsertCurso);
    }
    
    function ativaDesativa($mysqli){
         $sqlUpdateCurso="
            UPDATE  courses
                SET 
                    status = if(status=1,0,1)
                WHERE 
                    id = '".$this->id."';
            ";
        
//        echo $sqlUpdateCurso;
        $mysqli->query($sqlUpdateCurso);
    }

}
