<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Support\DemoContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'notices' => Notice::visible()->latestFirst()->take(3)->get(),
            'events' => DemoContent::events(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function message(string $person): View
    {
        abort_unless(in_array($person, ['chairman', 'principal'], true), 404);

        return view('pages.message', ['person' => $person]);
    }

    public function academic(): View
    {
        return view('pages.academic');
    }

    public function schoolHours(): View
    {
        return view('pages.school-hours');
    }

    public function uniform(): View
    {
        return view('pages.uniform');
    }

    public function calendar(): View
    {
        return view('pages.calendar', ['events' => DemoContent::events()]);
    }

    public function facilities(): View
    {
        return view('pages.facilities');
    }

    public function administration(): View
    {
        return view('pages.administration');
    }

    public function rules(): View
    {
        return view('pages.rules');
    }

    public function admission(): View
    {
        return view('pages.admission');
    }

    public function admissionApply(): View
    {
        return view('pages.admission-apply');
    }

    public function admissionSubmit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_name' => ['required', 'string', 'max:120'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female'],
            'class' => ['required', 'in:play,nursery,kg,one,two,three,four,five'],
            'guardian_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:120'],
            'address' => ['required', 'string', 'max:500'],
            'previous_school' => ['nullable', 'string', 'max:160'],
        ]);

        // TODO (Admissions module): save the application to the database instead of the log.
        Log::info('Online admission application', $data);

        return back()->with('status', __('Thank you. Your application has been received. The school office will contact you soon.'));
    }

    public function notices(Request $request): View
    {
        $category = $request->query('category');

        if (! array_key_exists((string) $category, Notice::CATEGORIES)) {
            $category = null;
        }

        $notices = Notice::visible()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->latestFirst()
            ->paginate(12)
            ->withQueryString();

        return view('pages.notices.index', ['notices' => $notices, 'category' => $category]);
    }

    public function notice(string $slug): View
    {
        $notice = Notice::visible()->where('slug', $slug)->firstOrFail();

        $others = Notice::visible()->whereKeyNot($notice->getKey())->latestFirst()->take(4)->get();

        return view('pages.notices.show', ['notice' => $notice, 'others' => $others]);
    }

    public function gallery(): View
    {
        return view('pages.gallery', ['photos' => DemoContent::gallery()]);
    }

    public function careers(): View
    {
        return view('pages.careers', [
            'notices' => Notice::visible()->where('category', 'recruitment')->latestFirst()->get(),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:120'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        // TODO (Contact messages module): save to the database so staff see it in /admin.
        Log::info('Contact form message', $data);

        return back()->with('status', __('Thank you for contacting us. We will reply as soon as possible.'));
    }
}
