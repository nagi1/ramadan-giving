<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\GivingEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckOrSaveGivingEnteryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // identifier should be required when name and phone are not provided
        // at least one of the 3 felids should be provided
        // either name and phone or identifier
        $data = $request->validate([
            'name' => 'nullable',
            'phone' => 'nullable|numeric',
            'identifier' => 'nullable|numeric|required_without_all:name,phone',
        ]);

        // search for the giving entry by whatever provided praitorize by identifier
        // make sure not to use orWhere on nullable fields
        $givingEntryQuery = GivingEntry::query();

        if ($request->identifier) {
            $givingEntryQuery->where('identifier', $request->identifier);
        } elseif ($request->name && $request->phone) {
            $givingEntryQuery->where('name', $request->name)->orWhere('phone', $request->phone);
        } elseif ($request->name) {
            $givingEntryQuery->where('name', $request->name);
        } elseif ($request->phone) {
            $givingEntryQuery->where('phone', $request->phone);
        }

        $givingEntry = $givingEntryQuery->first();

        if ($givingEntry) {
            return redirect()->back()->with('givingEntry', $givingEntry);
        }

        $data['campaign_id'] = Campaign::first()->id;
        $data['user_id'] = Auth::id();

        // if no giving entry found create a new one
        try {
            $givingEntry = GivingEntry::create($data);
        } catch (\Exception $e) {
            // if the error is UniqueConstraintViolationException then the entry already exists
            if ($e->getCode() === '23000' && Str::contains($e->getMessage(), 'giving_entries_name_unique')) {
                return redirect()->back()->with('error', 'الاسم موجود بالفعل، يرجى التحقق من البيانات والمحاولة مرة أخرى.');
            }

            if ($e->getCode() === '23000' && Str::contains($e->getMessage(), 'giving_entries_phone_unique')) {
                return redirect()->back()->with('error', 'رقم الهاتف موجود بالفعل، يرجى التحقق من البيانات والمحاولة مرة أخرى.');
            }

            if ($e->getCode() === '23000' && Str::contains($e->getMessage(), 'giving_entries_identifier_unique')) {
                return redirect()->back()->with('error', 'المعرف الرقمي  موجود بالفعل، يرجى التحقق من البيانات والمحاولة مرة أخرى.');
            }

            if (! App::isProduction()) {
                throw $e;
            }

            return redirect()->back()->with('error', 'حدث خطأ ما، يرجى المحاولة مرة أخرى.');
        }

        return redirect()->back()->with('success', 'لم يتم العثور على بيانات سابقة وتم حفظ البيانات الجديدة بنجاح.');
    }
}
