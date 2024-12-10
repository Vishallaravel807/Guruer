<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\SubCategory;
use App\Models\Subject;
use App\Models\Speciality;
use App\Models\FebricType;
use App\Models\SubscriptionPlan;
use App\Models\Category;
use App\Models\DocumentProd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;
use Validator;
use DB;
use Hash;


class MasterController extends Controller
{
    /*******************[Subcategory Master Start]************************/
    public function getSubcategory()
    {
        //This function is for getting the size
        $subcategory_list = SubCategory::where('is_deleted','=','0')->orderBy('id', 'desc')->get();
        return view('admin.master.subcategory_list',compact('subcategory_list'));
    }
    public function addSubcategory(Request $request , $id = null)
    {
        //This function is for add/update the size
        $category   = Category::where('is_deleted','=','0')->orderBy('category_id', 'desc')->get();
        $subcategory_detail='';
        if($id)
        {
            $subcategory_detail = SubCategory::where('id', $id)->first();
        }
        if ($request->isMethod('post')) {

            if($request->subcategory_id)
            {
                //This section is for update the size
                $subcategory = SubCategory::where('subcategory_name', $request->subcategory_name)
                        ->where('is_deleted', 0)
                        ->where('id','!=', $request->subcategory_id)
                        ->first();
                if($subcategory)
                {
                    return back()->with([
                        'error' => 'This subcategory is already exist',
                        'id' => $request->$subcategory_id,
                    ]);
                }
                else
                {
                    DB::table('master_subcategory')
                            ->where('id', $request->subcategory_id)
                            ->update([
                            'category_id' => $request->category_name,
                            'subcategory_name' => trim($request->subcategory_name)
                        ]);

                        Session::flash('message', 'Subcategory Updated Sucessfully!');
                        return redirect()->to('/admin/getSubcategory');
                }
            }
            else{
                //This section is for add size
                $subcategory = SubCategory::where('subcategory_name', $request->subcategory_name)
                    ->where('is_deleted', 0)
                    ->first();
                if($subcategory)
                {
                    return back()->with('error','This subcategory is already exist');
                }
                else
                {
                    $subcategory               = new SubCategory;
                    $subcategory->category_id  = $request->category_name;
                    $subcategory->subcategory_name    = trim($request->subcategory_name);
                    $subcategory->is_deleted   = "0";
                    $subcategory->save();
                    $subcategory_id = $subcategory->id;
                    Session::flash('message', 'Subcategory added Sucessfully!');

                    return redirect()->to('/admin/getSubcategory');
                }
            }

        }
        return view('admin.master.add_subcategory',compact('subcategory_detail','category'));
    }
    public function changesizeStatus(Request $request)
    {
        //This function is for change the size status
        $result =  DB::table('size_master')
                ->where('id', $request->id)
                ->update(
                    ['is_active' => $request->status]
                );
        if ($result){
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } else{
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }
    public function deleteSubcategory($id){

        $result =  DB::table('master_subcategory')
                ->where('id', $id)
                ->update(
                    ['is_deleted' => '1']
                );
        if ($result){
            Session::flash('message', 'Subcategory deleted Sucessfully!');
            return redirect()->to('/admin/getSubcategory');
        } else{
            Session::flash('message', 'Failed to delete Size');
            return redirect()->to('/admin/getSubcategory');
        }
   }
   /*******************[Size Master End]************************/

    /*******************[Color Master Start]************************/
    public function Subject()
    {

        //This function is for getting the Color
        $subject_list = Subject::where('is_deleted','=','0')->orderBy('id', 'desc')->get();
        return view('admin.master.subject_list',compact('subject_list'));
    }

    public function getSubcategories(Request $request){
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();

        return response()->json([
            'subcategories' => $subcategories
        ]);
    }



    public function addSubject(Request $request , $id = null)
    {
        //This function is for add/update the Color
        $category   = Category::where('is_deleted','=','0')->orderBy('category_id', 'desc')->get();
        $subcategory   = SubCategory::where('is_deleted','=','0')->orderBy('category_id', 'desc')->get();
        $subject_detail='';
        if($id)
        {
            $subject_detail = Subject::where('id', $id)->first();
        }
        if ($request->isMethod('post')) {

            if($request->subject_id)
            {
                //This section is for update the Color
                $subject = Subject::where('subject_name', $request->subject_name)
                            ->where('is_deleted', 0)
                            ->where('id','!=', $request->subject_id)
                            ->first();


                if($subject)
                {
                    return back()->with([
                        'error' => 'This subject name is already exist',
                        'id' => $request->subject_id,
                    ]);
                }
                else
                {
                    DB::table('subjects')
                            ->where('id', $request->subject_id)
                            ->update([
                            'category_id' => $request->category_name,
                            'subcategory_id' => $request->subcategory_name,
                            'subject_name' => trim($request->subject_name)
                        ]);

                        Session::flash('message', 'Subject Updated Sucessfully!');
                        return redirect()->to('/admin/Subjects');
                }
            }
            else{
                //This section is for add Color
                $subject =Subject::where('subject_name', $request->subject_name)
                        ->where('is_deleted', 0)
                        ->first();
                if($subject)
                {
                    return back()->with('error','This Subject is already exist');
                }
                else
                {
                    $subject                 = new Subject;
                    $subject->category_id    = $request->category_name;
                    $subject->subcategory_id = $request->subcategory_name;
                    $subject->subject_name   = $request->subject_name;
                    $subject->is_active      = "1";
                    $subject->is_deleted     = "0";
                    $subject->save();
                    $subject_id = $subject->subject_id;
                    Session::flash('message', 'subject added Sucessfully!');

                    return redirect()->to('/admin/Subjects');
                }
            }

        }
        return view('admin.master.add_subject',compact('subject_detail','category','subcategory'));
    }
    public function changesubjectStatus(Request $request)
    {
        //This function is for change the Color status
        $result =  DB::table('subjects')
                ->where('id', $request->id)
                ->update(
                    ['is_active' => $request->status]
                );
        if ($result){
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } else{
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }
    public function deleteColor($id){

        $result =  DB::table('color_master')
                ->where('color_id', $id)
                ->update(
                    ['is_deleted' => 1]
                );
        if ($result){
            Session::flash('message', 'Color deleted Sucessfully!');
            return redirect()->to('/admin/getColor');
        } else{
            Session::flash('message', 'Failed to delete Color');
            return redirect()->to('/admin/getColor');
        }
   }
   /*******************[Color Master End]************************/

   /*******************[Speciality Master Start]************************/
   public function getSpeciality()
   {
       //This function is for getting the Speciality
       $speciality_list = Speciality::where('is_deleted','=','0')->orderBy('speciality_id', 'desc')->get();
       return view('admin.master.speciality_list',compact('speciality_list'));
   }
   public function addSpeciality(Request $request , $id = null)
   {
       //This function is for add/update the Speciality
       $speciality_detail='';
       if($id)
       {
           $speciality_detail = Speciality::where('speciality_id', $id)->first();
       }
       if ($request->isMethod('post')) {

           if($request->speciality_id)
           {
               //This section is for update the Speciality
               $speciality = Speciality::where('speciality_name', $request->speciality_name)
                                    ->where('is_deleted', '0')
                                    ->where('speciality_id','!=', $request->speciality_id)
                                    ->first();


               if($speciality)
               {
                   return back()->with([
                       'error' => 'This speciality is already exist',
                       'id' => $request->speciality_id,
                   ]);
               }
               else
               {
                   DB::table('speciality_master')
                           ->where('speciality_id', $request->speciality_id)
                           ->update([
                           'speciality_name' => trim($request->speciality_name)

                       ]);

                       Session::flash('message', 'Speciality Updated Sucessfully!');
                       return redirect()->to('/admin/getSpeciality');
               }
           }
           else{
               //This section is for add Speciality
               $speciality = Speciality::where('speciality_name', $request->speciality_name)
                                    ->where('is_deleted', '0')
                                    ->first();
               if($speciality)
               {
                   return back()->with('error','This Speciality is already exist');
               }
               else
               {
                   $user               = new Speciality;
                   $user->speciality_name    = trim($request->speciality_name);
                   $user->is_active    = "1";
                   $user->is_deleted   = "0";
                   $user->save();
                   $user_id = $user->speciality_id;
                   Session::flash('message', 'Color added Sucessfully!');

                   return redirect()->to('/admin/getSpeciality');
               }
           }

       }
       return view('admin.master.add_speciality',compact('speciality_detail'));
   }
   public function changeSpecialityStatus(Request $request)
   {
       //This function is for change the Speciality status
       $result =  DB::table('speciality_master')
               ->where('speciality_id', $request->id)
               ->update(
                   ['is_active' => $request->status]
               );
       if ($result){
           return response()->json(['success' => true, 'message' => 'Status updated successfully']);
       } else{
           return response()->json(['success' => false, 'message' => 'Failed to update status']);
       }
   }
   public function deleteSpeciality($id){

       $result =  DB::table('speciality_master')
               ->where('speciality_id', $id)
               ->update(
                   ['is_deleted' => 1]
               );
       if ($result){
           Session::flash('message', 'Speciality deleted Sucessfully!');
           return redirect()->to('/admin/getSpeciality');
       } else{
           Session::flash('message', 'Failed to delete Speciality');
           return redirect()->to('/admin/getSpeciality');
       }
  }
  /*******************[Speciality Master End]************************/

  /*******************[Febric Type  Master Start]************************/
  public function getFebricType()
  {
      //This function is for getting the Febric Type
      $febric_type_list = FebricType::where('is_deleted','=','0')->orderBy('febric_type_id', 'desc')->get();
      return view('admin.master.febric_type_list',compact('febric_type_list'));
  }
  public function addFebricType(Request $request , $id = null)
  {
      //This function is for add/update the Febric Type
      $febric_type_detail='';
      if($id)
      {
          $febric_type_detail = FebricType::where('febric_type_id', $id)->first();
      }
      if ($request->isMethod('post')) {

          if($request->febric_type_id)
          {
              //This section is for update the Febric Type
              $febric = FebricType::where('febric_type_name', $request->febric_type_name)
                                   ->where('is_deleted', '0')
                                   ->where('febric_type_id','!=', $request->febric_type_id)
                                   ->first();


              if($febric)
              {
                  return back()->with([
                      'error' => 'This Febric Type is already exist',
                      'id' => $request->febric_type_id,
                  ]);
              }
              else
              {
                  DB::table('febric_type_master')
                          ->where('febric_type_id', $request->febric_type_id)
                          ->update([
                          'febric_type_name' => trim($request->febric_type_name)

                      ]);

                      Session::flash('message', 'Febric Type Updated Sucessfully!');
                      return redirect()->to('/admin/getFebricType');
              }
          }
          else{
              //This section is for add Febric Type
              $febric = FebricType::where('febric_type_name', $request->febric_type_name)
                                   ->where('is_deleted', '0')
                                   ->first();
              if($febric)
              {
                  return back()->with('error','This Febric Type is already exist');
              }
              else
              {
                  $user               = new FebricType;
                  $user->febric_type_name    = trim($request->febric_type_name);
                  $user->is_active    = "1";
                  $user->is_deleted   = "0";
                  $user->save();
                  $user_id = $user->febric_type_id;
                  Session::flash('message', 'Febric Type added Sucessfully!');

                  return redirect()->to('/admin/getFebricType');
              }
          }

      }
      return view('admin.master.add_febric_type',compact('febric_type_detail'));
  }
  public function changeFebricTypeStatus(Request $request)
  {
      //This function is for change the Febric Type status
      $result =  DB::table('febric_type_master')
              ->where('febric_type_id', $request->id)
              ->update(
                  ['is_active' => $request->status]
              );
      if ($result){
          return response()->json(['success' => true, 'message' => 'Status updated successfully']);
      } else{
          return response()->json(['success' => false, 'message' => 'Failed to update status']);
      }
  }
  public function deleteFebricType($id){

      $result =  DB::table('febric_type_master')
              ->where('febric_type_id', $id)
              ->update(
                  ['is_deleted' => 1]
              );
      if ($result){
          Session::flash('message', 'Febric Type deleted Sucessfully!');
          return redirect()->to('/admin/getFebricType');
      } else{
          Session::flash('message', 'Failed to delete Febric Type');
          return redirect()->to('/admin/getFebricType');
      }
 }
 /*******************[Febric Type Master End]************************/

 /*******************[Subscription Plan Master Start]************************/
 public function getPlans()
 {
     //This function is for getting the Plan
     $plan_list = SubscriptionPlan::where('is_deleted','=','0')->orderBy('plan_id', 'desc')->get();
     return view('admin.master.plan_list',compact('plan_list'));
 }
 public function addPlan(Request $request , $id = null)
 {
     //This function is for add/update the Plan
     $plan_detail='';
     if($id)
     {
         $plan_detail = SubscriptionPlan::where('plan_id', $id)->first();
     }
     if ($request->isMethod('post')) {

         if($request->plan_id)
         {
             //This section is for update the Plan
             $febric = SubscriptionPlan::where('plan_name', $request->plan_name)
                                  ->where('is_deleted', '0')
                                  ->where('plan_id','!=', $request->plan_id)
                                  ->first();


             if($febric)
             {
                 return back()->with([
                     'error' => 'This Subscription plan is already exist',
                     'id' => $request->plan_id,
                 ]);
             }
             else
             {
                 DB::table('sub_plans')
                         ->where('plan_id', $request->plan_id)
                         ->update([
                         'plan_name' => trim($request->plan_name),
                         'plan_html' => $request->plan_html,
                         'plan_amount' => $request->plan_amount

                     ]);

                     Session::flash('message', 'Subscription Plan Updated Sucessfully!');
                     return redirect()->to('/admin/getPlans');
             }
         }
         else{
             //This section is for add Plan
             $febric = SubscriptionPlan::where('plan_name', $request->plan_name)
                                  ->where('is_deleted', '0')
                                  ->first();
             if($febric)
             {
                 return back()->with('error','This Subscription Plan is already exist');
             }
             else
             {
                 $user               = new SubscriptionPlan;
                 $user->plan_name    = trim($request->plan_name);
                 $user->plan_html    = $request->plan_html;
                 $user->plan_amount    = $request->plan_amount;
                 $user->is_active    = "1";
                 $user->is_deleted   = "0";
                 $user->save();
                 $user_id = $user->plan_id;
                 Session::flash('message', 'Subscription Plan added Sucessfully!');

                 return redirect()->to('/admin/getPlans');
             }
         }

     }
     return view('admin.master.add_plan',compact('plan_detail'));
 }
 public function changePlanStatus(Request $request)
 {
     //This function is for change the Plan status
     $result =  DB::table('sub_plans')
             ->where('plan_id', $request->id)
             ->update(
                 ['is_active' => $request->status]
             );
     if ($result){
         return response()->json(['success' => true, 'message' => 'Status updated successfully']);
     } else{
         return response()->json(['success' => false, 'message' => 'Failed to update status']);
     }
 }
 public function deletePlan($id){

     $result =  DB::table('sub_plans')
             ->where('plan_id', $id)
             ->update(
                 ['is_deleted' => 1]
             );
     if ($result){
         Session::flash('message', 'Subscription Plan deleted Sucessfully!');
         return redirect()->to('/admin/getPlans');
     } else{
         Session::flash('message', 'Failed to delete Subscription');
         return redirect()->to('/admin/getPlans');
     }
}
/*******************[Subscription Plan Master End]************************/

 /*******************[Category Master Start]************************/
 public function getCategory()
 {
     //This function is for getting the Category
     $cat_list = Category::where('is_deleted','=','0')->orderBy('category_id', 'desc')->get();
     return view('admin.master.category_list',compact('cat_list'));
 }
 public function addCategory(Request $request , $id = null)
 {
     //This function is for add/update the Category
     $cate_detail='';
     if($id)
     {
         $cate_detail = Category::where('category_id', $id)->first();
     }
     if ($request->isMethod('post')) {

         if($request->category_id)
         {
             //This section is for update the Category
             $febric = Category::where('category_name', $request->category_name)
                                  ->where('is_deleted', '0')
                                  ->where('category_id','!=', $request->category_id)
                                  ->first();

             if($febric)
             {
                 return back()->with([
                     'error' => 'This Category is already exist',
                     'id' => $request->category_id,
                 ]);
             }
             else
             {
                 DB::table('master_category')
                         ->where('category_id', $request->category_id)
                         ->update([
                         'category_name' => trim($request->category_name),
                     ]);

                     Session::flash('message', 'Category Updated Sucessfully!');
                     return redirect()->to('/admin/getCategory');
             }
         }
         else{
             //This section is for add Category
             $febric = Category::where('category_name', $request->category_name)
                                  ->where('is_deleted', '0')
                                  ->first();
             if($febric)
             {
                 return back()->with('error','This Category is already exist');
             }
             else
             {
                 $user               = new Category;
                 $user->category_name    = trim($request->category_name);
                 $user->is_active        = "1";
                 $user->is_deleted       = "0";
                 $user->save();
                 $user_id = $user->category_id;
                 Session::flash('message', 'Category added Sucessfully!');

                 return redirect()->to('/admin/getCategory');
             }
         }

     }
     return view('admin.master.add_category',compact('cate_detail'));
 }
 public function changeCategoryStatus(Request $request)
 {
     //This function is for change the Category status
     $result =  DB::table('master_category')
             ->where('category_id', $request->id)
             ->update(
                 ['is_active' => $request->status]
             );
     if ($result){
         return response()->json(['success' => true, 'message' => 'Status updated successfully']);
     } else{
         return response()->json(['success' => false, 'message' => 'Failed to update status']);
     }
 }
 public function deleteCategory($id){

     $result =  DB::table('master_category')
             ->where('category_id', $id)
             ->update(
                 ['is_deleted' => '1']
             );
     if ($result){
         Session::flash('message', 'Category deleted Sucessfully!');
         return redirect()->to('/admin/getCategory');
     } else{
         Session::flash('message', 'Failed to delete Category');
         return redirect()->to('/admin/getCategory');
     }
}
/*******************[Category Master End]************************/
}
