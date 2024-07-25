<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\SystemInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class SystemInformationController extends Controller
{
    public function systemInformation() {
        $data = SystemInformation::first();
        return view('backend.pages.system-information.index', compact('data'));
    }

    public function systemInformationPost(Request $request, $id) {

        $validated = $request->validate([
            'number' => 'required|regex:/^(?:\+?88)?01[35-9]\d{8}$/',
            'email' => 'required|email',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
            'location' => 'required'
        ]);

        $data = SystemInformation::findOrFail($id);
        $oldLogo = $data->logo;
        $oldFav = $data->fav;

        $logo = "";
        $logoPath = public_path('storage\\' . $oldLogo);
        if (!empty($request->logo)) {
            if (File::exists($logoPath)) {
                File::delete($logoPath);
            }
            $logo = $request->logo->store('about/logo', 'public');
        } else {
            $logo = $oldLogo;
        }

        $fav = "";
        $favPath = public_path('storage\\' . $oldFav);
        if (!empty($request->favicon)) {
            if (File::exists($favPath)) {
                File::delete($favPath);
            }
            $fav = $request->favicon->store('about/fav', 'public');
        } else {
            $fav = $oldFav;
        }

        $done = SystemInformation::where('id', $id)->update([
            'number' => $request->number,
            'email' => $request->email,
            'location' => $request->location,
            'logo' => $logo,
            'fav' => $fav,
            'updated_at' => Carbon::now(),
        ]);

        if($done){
            return back()->with('success', 'Information Updated');
        }else {
            return back()->with('error', 'Information Not Updated!');
        }
    }
}
