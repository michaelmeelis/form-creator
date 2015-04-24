<?php

namespace michaelmeelis\FormCreator\Factory\FormFieldCollection;

use michaelmeelis\FormCreator\Factory\FormFieldCollection\Adapters;
use michaelmeelis\FormCreator\Factory\FormFieldCollection\Adapters\BaseAdapter;
use michaelmeelis\FormCreator\Factory\FormFieldCollection\Adapters\NullAdapter;

class AdapterFactory
{
    const ADAPTER_NAMESPACE = "BeFriends\\Admin\\FormCreator\\Factory\\FormFieldCollection\\Adapters\\";
    const COLLECTION_SETTINGS_KEY_NAME = "collectionAdapters";

    private $defaultAdapters = [
        'DocBlockAdapter',
        'DocBlockModelAdapter',
    ];

    private $settings;

    /**
     * @param array $settings
     * @param BaseAdapter[] $adapters
     * @return array
     */
    public function createAdapters(array $settings, array $adapters = [])
    {
        $this->settings = $settings;
        $adapters = $adapters + $this->buildSettingAdapters();
        $adapters = $adapters + $this->buildDefaultAdapters();

        return $adapters;
    }

    private function buildSettingAdapters()
    {
        $adapters = [];

        $settingAdapters = $this->getAdaptersFromSettings();
        foreach ($settingAdapters as $adapterName) {
            $adapters[] = $this->createAdapter(self::ADAPTER_NAMESPACE . $adapterName);
        }

        return $adapters;
    }

    private function buildDefaultAdapters()
    {
        $adapters = [];

        foreach ($this->defaultAdapters as $adapterName) {
            $adapters[] = $this->createAdapter(self::ADAPTER_NAMESPACE . $adapterName);
        }

        return $adapters;
    }

    /**
     * @return array
     */
    private function getAdaptersFromSettings()
    {
        if (isset($this->settings[self::COLLECTION_SETTINGS_KEY_NAME]) &&
            is_array($this->settings[self::COLLECTION_SETTINGS_KEY_NAME])
        ) {
            return $this->settings[self::COLLECTION_SETTINGS_KEY_NAME];
        }

        return [];
    }

    /**
     * @param $adapterClassName
     * @return NullAdapter
     * @todo Laravel log function please remove
     */
    private function createAdapter($adapterClassName)
    {
        if (class_exists($adapterClassName)) {
            return new $adapterClassName($this->settings);
        }

        \Log::error('Adapter not found: ' . $adapterClassName);

        return new NullAdapter($adapterClassName);
    }
} 