<?php
function karretform($name, $selectedOption = null) {
    $options = DB::table('karrat')->get();
    $selectField = '<select class="form-control" name="' . $name . '">';
    foreach($options as $item) {
      $isSelected = ($selectedOption !== null && $item->id == $selectedOption) ? 'selected' : '';
      $selectField .= '<option value="' . $item->manin_id . '" ' . $isSelected . '>' . $item->name . '</option>';
    }
    $selectField .= '</select>';
    return $selectField;
  }
  function count_karret_per($id,$karret)
  {
    $t = 0;
    $data = DB::table('karrat')->where('manin_id',$karret)->first();
    if($data){
        $cl =  $data->per*$karret;
        $t = $t+$cl;
    }
    return $t;
  }
?>