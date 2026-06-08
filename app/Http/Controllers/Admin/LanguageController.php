<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\LanguageTranslation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Auth;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::paginate(10);
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'language_code' => 'required|string|unique:languages,language_code',
        ]);

        Language::create([
            'title' => $request->title,
            'language_code' => $request->language_code,
            'addedby_id' => Auth::id(),
        ]);

        return redirect()->route('admin.languages')->with('success','Language added successfully.');
    }

    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'title' => 'required|string',
            'language_code' => 'required|string|unique:languages,language_code,'.$language->id,
        ]);

        $language->update([
            'title' => $request->title,
            'language_code' => $request->language_code,
            'active' => $request->has('active') ? 1 : 0,
            'editedby_id' => Auth::id(),
        ]);

        return redirect()->route('admin.languages')->with('success','Language updated successfully.');
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->route('admin.languages')->with('success','Language deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->active = $request->mode;
        $language->save();
        return response()->json(['status'=>true,'msg'=>'Language status updated']);
    }

    public function translations(Language $language)
    {
        // dd($language);
        $lang_keys = LanguageTranslation::where('lang', 'en')->paginate(500);
        return view('admin.languages.translations',compact('language','lang_keys'));
    }

    public function storeTranslationValues(Request $request)
    {
        foreach($request->values as $key => $value){
            LanguageTranslation::updateOrCreate(
                ['lang'=>$request->lang,'lang_key'=>$key],
                ['lang_value'=>$value,'editedby_id'=>Auth::id()]
            );
        }
        return back()->with('success','Translations updated successfully.');
    }

    public function translationSearchAjax(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $query = $request->q;
        $lang_keys = LanguageTranslation::where('lang',$language->language_code)
            ->when($query,function($q) use ($query){
                $q->where('lang_key','like',"%$query%");
            })
            ->paginate(20);

        $html = view('admin.languages.partials.translation-table', [
            'lang_keys' => $lang_keys,
            'language' => $language
        ])->render();
        
        return response()->json(['success'=>true,'page'=>$html]);
    }

public function updateStatus(Language $language)
{
    // 1. Save selected language in session
    session(['locale' => $language->language_code]);

    // 2. Set Laravel locale immediately
    \Illuminate\Support\Facades\App::setLocale($language->language_code);

    // 3. Optional: flash a success message
    session()->flash('success', 'Language changed successfully');

    // 4. Redirect back
    return back();
}
}