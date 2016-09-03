<?php

class Production extends CI_Model {

    var $root;     // Our root element, from the XML document
    var $totalPickAvg; // Overall pick rate average
    var $totalBanAvg; //Overall ban rate average

    /**
     * Constructor.
     */

    function __construct() {
        parent::__construct();
        $this->root = simplexml_load_file(XML_FOLDER . 'champions.xml');
        $this->overallPicked = "";
        $this->overallBanned = "";
    }

    function createTable() {
    }

    function get_year() {
        return $this->root["year"];
    }
    
    function build_lanes(){
        $lanes = array();
        foreach ($this->root->sources->source as $source) {
           $lanes[] = array('lane' => (string) ucfirst(strtolower($source['metalane'])) . " Lane",
                            'champions' => $this->build_champions($source),
                            'mostpicked' => $this->calc_most_picked($source),
                            'mostbanned' => $this->calc_most_banned($source)
           );   
        }
        
        return $lanes;        
    }
    
    function build_champions($source){
        $champions = array();
        foreach ($source->champion as $champion) {
           $champions[] = array(
                                'name' => (string) $champion['name'],
                                'pickrate' => (string) $champion->popularity,
                                'banrate' => (string) $champion->banrate);         
        }
        
        return $champions;        
    }
    
    function calc_most_picked($source){
        $highestPick = -1;
        $mostPicked = "";
        foreach ($source->champion as $champion) {
            $curPick = (float)rtrim($champion->popularity,'%');
            if($curPick > $highestPick){
                $highestPick = $curPick;
                $mostPicked = $champion['name'];
            }
        }
        return $mostPicked;
    }
    
    function calc_most_banned($source){
        $highestBan = -1;
        $mostBanned = "";
        foreach ($source->champion as $champion) {
            $curBan = (float)rtrim($champion->banrate,'%');
            if($curBan > $highestBan){
                $highestBan = $curBan;
                $mostBanned = $champion['name'];
            }
        }
        return $mostBanned;
    }
    
    function get_picked_overall(){
        $highestPickOverall = -1;
        $mostPickedOverall = "";
        foreach($this->root->sources->source as $source){
            foreach($source->champion as $champion){
                $curPick = (float) rtrim($champion->popularity, '%');
                if($curPick > $highestPickOverall){
                    $highestPickOverall = $curPick;
                    $mostPickedOverall = $champion['name'];
                }
            }
        }
        return $mostPickedOverall;
    }
    
    function get_banned_overall(){
        $highestBanOverall = -1;
        $mostBannedOverall = "";
        foreach($this->root->sources->source as $source){
            foreach($source->champion as $champion){
                $curBan = (float) rtrim($champion->banrate, '%');
                if($curBan > $highestBanOverall){
                    $highestBanOverall = $curBan;
                    $mostBannedOverall = $champion['name'];
                }
            }
        }
        return $mostBannedOverall;
    }
    function get_data() {
        $result = array();
        // iterate over all countries in all regions
        foreach ($this->root->sources->source as $source)
            foreach ($source->champion as $champion) {
                    $row = array('name' => $champion['name']);
                    $row['pickrate'] = $champion['popularity'];
                    $row['banrate'] = $champion['banrate'];
                    $result[(string) $champion['name']] = $row;
            }
        ksort($result);
        return $result;
    }
    
    function build_headings(){
        $headings = array();
        $headings = array('heading' => '(000 bags)');
        foreach ($this->root->sources->source as $source) {
            $headings[] = array('heading' => (string) ucfirst(strtolower($source->attributes()->metalane)) . " Lane");
        }
        return $headings;

        /*
            $tableContents.= "<tr>";
            $tableContents.= "<td><h3>";
            $tableContents.= ucfirst(strtolower($source->attributes()->metalane)) . " Lane";
            $tableContents.="</h3></td>";
            $tableContents.= "</tr>";
         */
    }
}