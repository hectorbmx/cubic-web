<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Privacy Policy</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900 antialiased">
  <main class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold mb-6">Privacy Policy</h1>

    <p class="mb-4">
      This Privacy Policy describes how Cubic 33 collects, uses, and protects
      the personal information of its users.
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Information We Collect</h2>
    <p class="mb-4">
      We may collect personal information such as name, email address,
      phone number, and usage data when you register or use our services.
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Use of Information</h2>
    <p class="mb-4">
      The information collected is used to provide, maintain, and improve
      our services, as well as to communicate with users when necessary.
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Data Protection</h2>
    <p class="mb-4">
      We implement appropriate security measures to protect your information
      against unauthorized access, alteration, disclosure, or destruction.
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Third-Party Services</h2>
    <p class="mb-4">
      Cubic 33 does not sell or share personal data with third parties,
      except when required by law or to provide essential services.
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Changes to This Policy</h2>
    <p class="mb-4">
      This Privacy Policy may be updated from time to time. Any changes will
      be posted on this page.
    </p>

    <h2 class="text-xl font-semibold mt-6 mb-2">Contact</h2>
    <p>
      If you have any questions about this Privacy Policy, you may contact us at:
      <br>
      <strong>support@bmxmexico.com</strong>
    </p>

    <p class="mt-8 text-sm text-gray-500">
      Last updated: {{ now()->format('F Y') }}
    </p>
  </main>
</body>
</html>
