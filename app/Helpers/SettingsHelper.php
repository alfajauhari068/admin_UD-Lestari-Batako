<?php

if (!function_exists('setting')) {
  /**
   * Get a setting value by key
   *
   * @param string $key
   * @param mixed $default
   * @return mixed
   */
  function setting($key, $default = null)
  {
    $settings = app('settings');

    // Handle nested keys like 'company.name'
    if (str_contains($key, '.')) {
      $keys = explode('.', $key);
      $grouped = $settings->getGroupedSettings();

      $value = $grouped;
      foreach ($keys as $k) {
        if (isset($value[$k])) {
          $value = $value[$k];
        } else {
          return $default;
        }
      }
      return $value;
    }

    return $settings->$key ?? $default;
  }
}

if (!function_exists('settings')) {
  /**
   * Get all settings or settings by category
   *
   * @param string|null $category
   * @return mixed
   */
  function settings($category = null)
  {
    $settings = app('settings');

    if ($category) {
      $grouped = $settings->getGroupedSettings();
      return $grouped[$category] ?? [];
    }

    return $settings->getGroupedSettings();
  }
}