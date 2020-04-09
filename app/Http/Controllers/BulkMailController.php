<?php
namespace App\Http\Controllers;


use App\BulkMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Object_;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Voyager;

class BulkMailController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController {
  /**
   * POST BRE(A)D - Store data.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $slug = $this->getSlug($request);
    
    $dataType = \TCG\Voyager\Facades\Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    // Check permission
    $this->authorize('add', app($dataType->model_name));
    
    // Validate fields with ajax
    $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
    $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
    
    event(new BreadDataAdded($dataType, $data));
    
    if (!$request->has('_tagging')) {
      if (auth()->user()->can('browse', $data)) {
        $redirect = redirect()->route("voyager.{$dataType->slug}.index");
      } else {
        $redirect = redirect()->back();
      }
      
      return $redirect->with([
        'message'    => __('voyager::generic.successfully_added_new')." {$dataType->getTranslatedAttribute('display_name_singular')}",
        'alert-type' => 'success',
      ]);
    } else {
      return response()->json(['success' => true, 'data' => $data]);
    }
  }
}