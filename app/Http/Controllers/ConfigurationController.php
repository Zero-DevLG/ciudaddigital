<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Services\ConfigService;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }


    public function saveConfig(Request $request)
    {

        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'color_body' => 'required|string',
            'color_sidebar' => 'required|string',
            'color_navbar' => 'required|string',
            'color_info' => 'required|string',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('img', 'public');
        } else {
            $logoPath = null;
        }
    }
}
