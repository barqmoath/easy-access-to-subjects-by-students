<?php
namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('name')->get();
        return view('dashboard.settings.settings')->with([
            'settings' => $settings
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name'  => 'required|string|max:255|unique:settings',
            'value' => 'required|integer' 
        ]);

        $setting = Setting::find($id);
        $setting->name  = $request->input('name');
        $setting->value = $request->input('value');
        $setting->save();
        return back()->with('msg','Setting Updated Successfully !'); 
    }

    public function destroy($id)
    {
        Setting::where([['id','=',$id],['id','<>',1]])->delete();
        return back()->with('msg','Settings Removed !');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'  => 'required|string|max:255|unique:settings',
            'value' => 'required|integer' 
        ]);

        $setting = new Setting;
        $setting->name  =  strtolower(str_replace([' ','&','+','.','"','?','#','@','<','>','{','}','[',']','÷','*','%','$','(',')','_',',','،','='],'-',$request->input('name')));
        $setting->value = $request->input('value');
        $setting->save(); 
        return back()->with('msg','Setting Add Successfully !');
    }
}
