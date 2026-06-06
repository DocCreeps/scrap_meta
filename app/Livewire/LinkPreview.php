<?php

namespace App\Livewire;

use Livewire\Component;
use Embed\Embed;
use Exception;

class LinkPreview extends Component
{
    public string $url = '';
    public ?array $metadata = null;
    public ?string $error = null;
    public bool $loading = false;

    // Règles de validation
    protected $rules = [
        'url' => 'required|url',
    ];

    public function fetchPreview()
    {
        $this->validate();
        $this->error = null;
        $this->metadata = null;

        try {
            $embed = new Embed();
            $info = $embed->get($this->url);

            // On extrait les données essentielles
            $this->metadata = [
                'title' => $info->title ?? 'Aucun titre trouvé',
                'description' => $info->description ?? 'Pas de description disponible.',
                'image' => $info->image?->__toString() ?? null,
                'provider' => $info->providerName ?? parse_url($this->url, PHP_URL_HOST),
                'url' => $this->url,
            ];
        } catch (Exception $e) {
            $this->error = "Impossible de récupérer les informations de ce lien.";
        }
    }

    public function render()
    {
        return view('livewire.link-preview');
    }
}
