<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdquisitionShape;
use App\PropiertyDescription;
use App\UseType;
use App\SupportDocument;
use App\Propierty;
use App\Owner;
use App\PropiertyImage;
use App\PropiertyDocument;


class PropiertiesController extends Controller
{
    public function index(Request $request){
      return view('propierties.propierties');
    }
    public function get_propierties(Request $request){
    $page= isset($_POST['page']) ? intval($_POST['page']):1;
     $rows= isset($_POST['rows']) ? intval($_POST['rows']):10;
     $offset = ($page-1)*$rows;
     $sql="select count(*) from propierties";

     $host=config('database.connections.mysql.host');
     $username=config('database.connections.mysql.username');
     $password=config('database.connections.mysql.password');
     $db_name=config('database.connections.mysql.database');
     $connection=mysqli_connect("$host","$username","$password") or die("cannot connect server");
     $database=mysqli_select_db($connection,"$db_name") or die("cannot select db");
     $rs=mysqli_query($connection,$sql);
     $row=mysqli_fetch_row($rs);
     $result["total"]= $row[0];

     $propierties=Propierty::orderBy('id','asc')->skip($offset)->take($rows)->get();
     $items=array();
     foreach($propierties as $propierty){
       array_push($items, $propierty);
     }
     $result["rows"]=$items;
     // $row=$profiles->toArray($profiles);
     echo json_encode($result);
    }
    public function get_propierty_description(Request $request){
      $propierties_description = PropiertyDescription::orderBy('id')->get();
      echo json_encode($propierties_description);
    }

    public function get_use_types(Request $request){
      $use_types = UseType::orderBy('id')->get();
      echo json_encode($use_types);
    }
    public function get_adquisition_shapes(Request $request){
      $adquisition_shapes = AdquisitionShape::orderBy('id')->get();
      echo json_encode($adquisition_shapes);
    }
    public function get_support_documents(Request $request){
      $support_documents = SupportDocument::orderBy('id')->get();
      echo json_encode($support_documents);
    }

    public function get_owners(Request $request){
      $owners = Owner::orderBy('id')->get();
      echo json_encode($owners);
    }

    public function save_propierties(Request $request){
      $propierty = new Propierty();
      $propierty->inventory_number = $request->inventory_number;
      $propierty->propierty_location = $request->propierty_location;
      $propierty->ext_number = $request->ext_number;
      $propierty->int_number = $request->int_number;
      $propierty->surface = $request->surface;
      $propierty->book_value = $request->book_value;
      $propierty->accounting_item = $request->accounting_item;
      $propierty->notary_minutes = $request->notary_minutes;
      $propierty->rpp = $request->rpp;
      $propierty->current_situation = $request->current_situation;
      $propierty->notary = $request->notary;
      $propierty->document_date = $request->document_date;
      $propierty->document_number = $request->document_number;
      $propierty->propierty_account = $request->propierty_account;
      $propierty->catastral_key = $request->catastral_key;
      //$propierty->utm_coordinates = $request->utm_coordinates;
      $propierty->government_session = $request->government_session;
      $propierty->owner_id = $request->owner_id;
      $propierty->observations = $request->observations;
      $propierty->propierty_description_id =$request->propierty_description_id;
      $propierty->use_type_id = $request->use_type_id;
      $propierty->adquisition_shape_id = $request->adquisition_shape_id;
      $propierty->support_document_id = $request->support_document_id;
      $propierty->save();
      if($request->images) {
        $destinationPath = public_path('images');
        $images= $request->images;
        foreach ($images as $key => $image) {
          $name = $image->getClientOriginalName();
          $image->move($destinationPath,$name);
          $im = new PropiertyImage();
          $im->propierty_id = $propierty->id;
          $im->image=$name;
          $im->save();
        }
      }if($request->pdf){
        $destinationPath= public_path('documents');
        $pdf =$request->file('pdf');
        $name = $pdf->getClientOriginalName();
        $pdf->move($destinationPath, $name);
        $document = new PropiertyDocument();
        $document->propierty_id = $propierty->id;
        $document->document_name=$name;
        $document->save();
        }
      echo json_encode(array('success'=>true));
    }
    public function update_propierties(Request $request, $id){
      $requestData=$request->all();
      $propierty=Propierty::findOrfail($id);
      $propierty->update($requestData);
      if($request->images){
        $destinationPath = public_path('images');
        $images= $request->images;
        foreach ($images as $key => $image) {
          $name = $image->getClientOriginalName();
          $image->move($destinationPath,$name);
          $im = new PropiertyImage();
          $im->propierty_id = $id;
          $im->image=$name;
          $im->save();
        }
      }
      if ($request->pdf) {
          $destinationPath= public_path('documents');
          $pdf =$request->file('pdf');
          $name = $pdf->getClientOriginalName();
          $pdf->move($destinationPath, $name);
          $document = new PropiertyDocument();
          $document->propierty_id = $id;
          $document->document_name=$name;
          $document->save();
      }
      echo json_encode(array('success'=>true));
  }

  public function get_propierty(Request $request, $id){
    $propierty = Propierty::with('propierty_description','use_type','adquisition_shape','support_document','owner')->where('id',$id)->get();
    return $propierty;
  }
  public function get_images(Request $request, $id){
    $images = PropiertyImage::where('propierty_id', $id)->get();
    return $images;
  }

  public function get_documents(Request $request, $id){
    $documents = PropiertyDocument::where('propierty_id', $id)->get();
    return $documents;
  }

  public function check_propierties(Request $request){

      $propierties = Propierty::with('propierty_description','use_type','adquisition_shape','support_document','owner')->get();
      return view('propierties.newprop', compact('propierties'));
  }

  public function view_propierty(Request $request, $id){
    $propierties = Propierty::where('id', $id)->get();
    return view('propierties.propierty', compact('propierties'));
     // dd($propierty);
  }

}
