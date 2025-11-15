# 🚀 Profile Feature - Quick Setup

## ✅ Verification Checklist

Sebelum testing, pastikan:
- [ ] Database migration sudah dijalankan (table `user_profiles` exists)
- [ ] User sudah login
- [ ] Vite dev server berjalan

## 🧪 Quick Test

### 1. Check Database Table
```bash
php artisan tinker
```
```php
// Check if user_profiles table exists
Schema::hasTable('user_profiles'); // Should return true

// Check table columns
Schema::getColumnListing('user_profiles');
```

### 2. Test Profile Page Access
```
URL: http://localhost:8000/profile
```

**What to expect:**
- ✅ Page loads successfully
- ✅ Shows user account info (name, email, role badge)
- ✅ Shows empty form if no profile data exists
- ✅ All form fields are visible and functional

### 3. Test Profile Update

**Fill the form with:**
```
NIK: 3201234567890123
Phone: 08123456789
Date of Birth: 1990-01-01
Gender: Laki-laki
Province: DKI Jakarta
City: Jakarta Selatan
Address: Jl. Example No. 123, RT 01/02
```

**Click "Save Changes"**

**Expected Result:**
- ✅ Toast notification: "Profile updated successfully"
- ✅ Form stays on page with data intact
- ✅ Can edit fields again and re-save

### 4. Verify Database
```bash
php artisan tinker
```
```php
// Check saved profile
$user = \App\Models\User::first();
$user->profile;

// Should show all saved data
```

### 5. Test Form Validation

**Try these to test validation:**

**Test 1: Invalid Gender**
```
Gender: "Other" (not in dropdown)
```
❌ Should show validation error

**Test 2: Very Long NIK**
```
NIK: "32012345678901234567890" (more than 20 chars)
```
❌ Should show validation error

**Test 3: Invalid Date**
```
Date of Birth: "2050-01-01" (future date is technically valid in our validation)
```
✅ Will save (add custom validation if needed)

## 🎯 Test Scenarios

### Scenario 1: New User (First Time)
1. Login with any account
2. Go to `/profile`
3. All fields should be empty
4. Fill all fields
5. Click Save
6. Success toast appears
7. Refresh page
8. All data should still be there

### Scenario 2: Existing User (Update)
1. Login with account that has profile
2. Go to `/profile`
3. All fields should be pre-filled
4. Change some fields (e.g., phone number)
5. Click Save
6. Success toast appears
7. Check database - should see updated data

### Scenario 3: Partial Data
1. Login
2. Go to `/profile`
3. Fill only NIK and Phone Number
4. Leave other fields empty
5. Click Save
6. Should save successfully (all fields are nullable)

### Scenario 4: Role Badge Display
Test with different user roles:

**Pasien Account:**
- Badge color: Green
- Text: "Pasien"

**Fasyankes Account:**
- Badge color: Blue
- Text: "Fasyankes"

**Dinkes Account:**
- Badge color: Purple
- Text: "Dinkes"

## 📊 Database Verification Commands

```bash
# Check if profile was created
php artisan tinker
```

```php
// Get user with profile
$user = \App\Models\User::with('profile')->find(1);
$user->profile;

// Check all profiles
\App\Models\UserProfile::all();

// Count profiles
\App\Models\UserProfile::count();

// Get users without profile
\App\Models\User::doesntHave('profile')->get();

// Get users with profile
\App\Models\User::has('profile')->get();
```

## 🐛 Common Issues & Solutions

### Issue 1: Page shows 404
**Solution:**
```bash
php artisan route:clear
php artisan route:list | grep profile
```
Should show:
```
GET|HEAD  profile .... profile.edit
PUT       profile .... profile.update
```

### Issue 2: Form doesn't save
**Check:**
1. Is user authenticated?
2. Check browser console for errors
3. Check Laravel logs: `storage/logs/laravel.log`
4. Try with dd() in controller:
```php
public function update(Request $request)
{
    dd($request->all()); // Check if data is received
}
```

### Issue 3: Toast notification doesn't show
**Solution:**
1. Check if Toast component is in AppLocalLayout
2. Check browser console for errors
3. Hard refresh: `Ctrl+Shift+R`

### Issue 4: Validation errors not showing
**Check in Vue DevTools:**
- `form.errors` should contain error messages
- Red border should appear on invalid fields

### Issue 5: Province dropdown empty
**Check:**
- `provinces` array in script section
- Should have 38 provinces
- Console should not show any errors

## 🔍 Debug Mode

### Enable Debug in ProfileController
```php
public function update(Request $request)
{
    \Log::info('Profile Update Request:', $request->all());
    
    $validated = $request->validate([...]);
    
    \Log::info('Validated Data:', $validated);
    
    $result = $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        $validated
    );
    
    \Log::info('Profile Saved:', $result->toArray());
    
    return redirect()->route('profile.edit')
        ->with('success', 'Profile updated successfully.');
}
```

Then check: `storage/logs/laravel.log`

## 📱 Responsive Testing

Test on different screen sizes:

**Desktop (1920x1080):**
- ✅ Two-column layout for date/gender and province/city
- ✅ Full width form

**Tablet (768px):**
- ✅ Two-column layout maintained
- ✅ Readable text

**Mobile (375px):**
- ✅ Single column layout
- ✅ Touch-friendly inputs
- ✅ Scrollable content

## ✨ Success Indicators

Everything is working correctly when:
- ✅ `/profile` page loads without errors
- ✅ User info displays correctly with role badge
- ✅ Form fields are functional
- ✅ Data saves to database
- ✅ Toast notification appears on save
- ✅ Validation works for invalid data
- ✅ Existing data loads on page refresh
- ✅ Can update profile multiple times
- ✅ Works for all user roles (Pasien, Fasyankes, Dinkes)

## 🎉 Ready to Use!

If all tests pass, the profile feature is ready for production use!

**Quick Access:**
```
URL: http://localhost:8000/profile
```

---

**Need Help?** Check `PROFILE_FEATURE.md` for complete documentation.
