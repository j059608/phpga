<?php

  /**
   * 
   *
   */
class GeneticAlgorithm {

  // gene size
  var $_genetic_size = 10;
  
  // a probability of mutation.
  // at least max number is 1.
  var $_mutaion_p = 3;
  var $_population_number = 10;
  var $_elite_num = 0;
  var $_elite_rate = 0.3;
  
    /**
     *
     */
    function __construct($population_number) 
    {
      $this->_population_number = $population_number;
      $this->_elite_num = $this->_population_number * $this->_elite_rate; 
    }

    /**
     * generate population.
     *
     */
    function generate($population_number = 10)
    {
        for($i = 0;$i < $population_number;$i++){
            for($j = 0;$j < $this->_genetic_size;$j++){
                $array_gene[$i][$j] = mt_rand(0,1);
            }
        }
        return $array_gene;
    }

    /**
     * one point crossover.
     */
    function crossover($gene,$another_gene)
    {
        $crossover_point = mt_rand(0,$this->_genetic_size);
        // crossover to generate new gene.
        for( $i = 0 ; $i < $this->_genetic_size ; $i++ ) {
	  if($i >= $crossover_point){
                $new_gene[$i] = $another_gene[$i];
            }else{
                $new_gene[$i] = $gene[$i];
            }
        }
        return $new_gene;
    }

    /**
     * simple elite select strategy.
     *
     */
    function select($cost_function,$array_gene) 
    {      
      $array_rank = array();
      // evluate gene group.
      for($i = 0;$i < $this->_population_number ;$i++) {
	$array_rank[$i] = $this->evaluate($cost_function,$array_gene[$i]);
      }
      // sorting by adaption.      
      $array_ranked_keys = array_keys($array_rank);
      for( $i = 0 ; $i < $this->_elite_num ;$i++  ){
	$temp  = array_shift($array_ranked_keys);
	$array_selected_gene[$i] = $array_gene[$temp];
      }
      return $array_selected_gene;
    }
    
    /**
     * This function evaluate gene that to match problem.
     * to need 
     *
     */
    function evaluate($function_name,$gene)
    {      
      if(function_exists($function_name)) {
	//Should be return Array function.
	return $function_name($gene);
      }else{
	return $gene;
      }
    }

    /**
     * simple random mutate by $_mutaion_p.
     *
     */
    function mutate($gene) 
    {        
      if(mt_rand($this->_mutaion_p,10000) < $this->_mutaion_p) {
	return shuffle($gene);
      }
      return $gene;
    }
  }// end of class
