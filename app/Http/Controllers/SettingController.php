<?php

namespace App\Http\Controllers;

use App\Setting;
use App\GroupSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('super')) {
            $groups = GroupSetting::with('settings')->get();

            return View('setting.index')->withGroups($groups);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->hasRole('super')) {
            try {
                
                DB::beginTransaction();
                
                $groups = $request->groups;
                foreach($groups as $group => $settings) {
                    $group = GroupSetting::find($group);
                    foreach($settings as $setting => $value) {
                        $x = $group->settings()->where('key', $setting)->first();
                        switch ($x->data_type) {
                            case 'string':
                                $x->value = ($value) ? $value : '';
                                break;
                            case 'integer':
                                $x->value = ($value) ? $value : '0';
                                break;
                            default:
                                $x->value = $value;
                                break;
                        }
                        $x->save();
                    }
                }

                DB::commit();

                Session::flash('success', 'Configurações do sistema Salvas com Sucesso');
                return redirect()->route('home');
            } catch (\Exception $e) {
                
                DB::rollback();

                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
                
            }
        }
    }

    static public function getSetting($setting_name) {
        return Setting::where('key', $setting_name)->first()->value;
    }

    static public function getGroupSetting($group_id) {
        return GroupSetting::with('settings')->find($group_id);
    }
}
