# 👤 User Profile Management

Halaman profile untuk mengupdate dan mengisi data personal user telah berhasil dibuat dengan menggunakan layout **AppLocalLayout**.

## 📋 Overview

Fitur ini memungkinkan user yang sudah login untuk:
- Melihat informasi akun (nama, email, role)
- Mengisi/update data personal lengkap
- Menyimpan data ke tabel `user_profiles`

## 🎯 Features

### 1. **Account Information Display**
- Menampilkan nama user
- Menampilkan email user
- Menampilkan role dengan badge berwarna

### 2. **Personal Information Form**
Formulir lengkap dengan field:
- **NIK** - Nomor Induk Kependudukan (16 digit)
- **Phone Number** - Nomor telepon
- **Date of Birth** - Tanggal lahir (date picker)
- **Gender** - Jenis kelamin (Laki-laki/Perempuan)
- **Province** - Provinsi (dropdown 38 provinsi Indonesia)
- **City** - Kota/Kabupaten
- **Address** - Alamat lengkap (textarea)

### 3. **Form Features**
- ✅ Auto-load existing data jika sudah pernah diisi
- ✅ Form validation di backend
- ✅ Error message display
- ✅ Success toast notification
- ✅ Loading state saat submit
- ✅ Responsive design

## 🗂️ Database Structure

### Table: `user_profiles`
```sql
- id (bigint, primary key)
- user_id (bigint, foreign key -> users.id)
- nik (varchar, nullable)
- phone_number (varchar, nullable)
- address (text, nullable)
- date_of_birth (date, nullable)
- gender (varchar, nullable)
- province (varchar, nullable)
- city (varchar, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, nullable) [soft delete]
```

### Relationship
- **User** `hasOne` **UserProfile**
- **UserProfile** `belongsTo` **User**

## 📁 File Structure

```
app/
  Http/
    Controllers/
      ProfileController.php         # Profile view & update logic
  Models/
    User.php                        # Updated: profile relationship
    UserProfile.php                 # NEW: Profile model

routes/
  web.php                          # Updated: Profile routes

resources/
  js/
    pages/
      Profile/
        Edit.vue                    # NEW: Profile page
    types/
      index.d.ts                   # Updated: UserProfile type
    layouts/
      AppLocalLayout.vue           # Used layout
```

## 🚀 Implementation Details

### 1. UserProfile Model
```php
class UserProfile extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'nik', 'phone_number', 'address',
        'date_of_birth', 'gender', 'province', 'city'
    ];
    
    protected $casts = [
        'date_of_birth' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### 2. User Model Relationship
```php
class User extends Authenticatable
{
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
```

### 3. ProfileController
```php
public function edit()
{
    $user = Auth::user();
    $profile = $user->profile ?? new UserProfile();
    
    return Inertia::render('Profile/Edit', [
        'user' => $user->load('profile'),
        'profile' => $profile,
    ]);
}

public function update(Request $request)
{
    $validated = $request->validate([...]);
    
    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        $validated
    );
    
    return redirect()->route('profile.edit')
        ->with('success', 'Profile updated successfully.');
}
```

### 4. Routes
```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});
```

### 5. Frontend (Vue)
```vue
<script setup>
const form = useForm({
    nik: props.profile?.nik || '',
    phone_number: props.profile?.phone_number || '',
    // ... other fields
});

const submitForm = () => {
    form.put('/profile', {
        preserveScroll: true,
    });
};
</script>
```

## 🎨 UI Components Used

- **AppLocalLayout** - Main layout
- **Card** - Container components
- **Button** - Actions
- **Input** - Text inputs
- **Select** - Dropdowns
- **Textarea** - Address field
- **Toast** - Success/error notifications
- **Icons** - Lucide Vue (UserIcon, Save)

## 🌐 Route Information

### URL
```
/profile
```

### Methods
- **GET** `/profile` - Display profile form
- **PUT** `/profile` - Update profile data

### Middleware
- `auth` - Must be logged in
- `verified` - Email must be verified (optional)

### Route Names
- `profile.edit` - View profile page
- `profile.update` - Update profile

## ✅ Validation Rules

```php
'nik' => ['nullable', 'string', 'max:20'],
'phone_number' => ['nullable', 'string', 'max:20'],
'address' => ['nullable', 'string', 'max:500'],
'date_of_birth' => ['nullable', 'date'],
'gender' => ['nullable', 'string', 'in:Laki-laki,Perempuan'],
'province' => ['nullable', 'string', 'max:100'],
'city' => ['nullable', 'string', 'max:100'],
```

## 🧪 Testing

### 1. Access Profile Page
```
URL: http://localhost:8000/profile
Method: GET
Auth: Required
```

**Expected:**
- ✅ Page loads with form
- ✅ Shows user info (name, email, role)
- ✅ Form fields empty if no profile data
- ✅ Form fields filled if profile exists

### 2. Submit Profile Form
```
URL: http://localhost:8000/profile
Method: PUT
Auth: Required
Data: {
    nik: "3201234567890123",
    phone_number: "08123456789",
    address: "Jl. Example No. 123",
    date_of_birth: "1990-01-01",
    gender: "Laki-laki",
    province: "DKI Jakarta",
    city: "Jakarta Selatan"
}
```

**Expected:**
- ✅ Data saved to database
- ✅ Toast notification: "Profile updated successfully"
- ✅ Form remains on page with updated data
- ✅ Can edit again

### 3. Test with Different Roles
Test dengan akun berbeda:
- **Pasien** - Bisa akses `/profile` ✅
- **Fasyankes** - Bisa akses `/profile` ✅
- **Dinkes** - Bisa akses `/profile` ✅

Semua role bisa akses profile karena tidak ada `check.dashboard` middleware.

## 📊 Province List

Form includes all 38 provinces of Indonesia:
- Aceh
- Sumatera Utara
- Sumatera Barat
- Riau
- Jambi
- Sumatera Selatan
- Bengkulu
- Lampung
- Kepulauan Bangka Belitung
- Kepulauan Riau
- DKI Jakarta
- Jawa Barat
- Jawa Tengah
- DI Yogyakarta
- Jawa Timur
- Banten
- Bali
- Nusa Tenggara Barat
- Nusa Tenggara Timur
- Kalimantan Barat
- Kalimantan Tengah
- Kalimantan Selatan
- Kalimantan Timur
- Kalimantan Utara
- Sulawesi Utara
- Sulawesi Tengah
- Sulawesi Selatan
- Sulawesi Tenggara
- Gorontalo
- Sulawesi Barat
- Maluku
- Maluku Utara
- Papua
- Papua Barat
- Papua Tengah
- Papua Pegunungan
- Papua Selatan
- Papua Barat Daya

## 🔒 Security

### Access Control
- Route protected by `auth` middleware
- Only authenticated users can access
- Users can only edit their own profile
- No cross-user profile access

### Data Validation
- All fields validated in backend
- Gender restricted to specific values
- Date format validation
- String length limits enforced

## 🐛 Troubleshooting

### Error: "Profile not found"
**Solution**: Profile akan otomatis dibuat saat pertama kali save. Tidak perlu pre-populate.

### Error: "Unauthorized"
**Solution**: User harus login terlebih dahulu
```bash
# Check if authenticated
Auth::check()
```

### Profile tidak tersave
**Solution**: Check validation errors
```php
// In ProfileController
dd($request->all(), $validated);
```

### Form tidak ke-populate
**Solution**: Check relationship di User model dan controller load
```php
// Pastikan di controller
$user->load('profile')
```

## 🎯 Common Use Cases

### Case 1: User Pertama Kali Isi Profile
1. Login ke aplikasi
2. Akses `/profile`
3. Form kosong (belum ada data)
4. Isi semua field
5. Klik "Save Changes"
6. Profile tersimpan ke database
7. Toast notification muncul

### Case 2: User Update Profile
1. Login ke aplikasi
2. Akses `/profile`
3. Form sudah terisi dengan data existing
4. Edit field yang ingin diubah
5. Klik "Save Changes"
6. Data terupdate di database
7. Form tetap dengan data terbaru

### Case 3: Validation Error
1. Login ke aplikasi
2. Akses `/profile`
3. Isi NIK lebih dari 20 karakter
4. Klik "Save Changes"
5. Error message muncul di bawah field NIK
6. Fix error dan submit lagi

## 🔄 Future Enhancements (Optional)

### 1. Add Photo Upload
```php
'photo' => ['nullable', 'image', 'max:2048'],
```

### 2. Add City Dropdown Based on Province
```vue
<select v-model="form.city">
  <option v-for="city in cities[form.province]">
    {{ city }}
  </option>
</select>
```

### 3. Add Profile Completeness Indicator
```vue
<div class="progress-bar">
  Profile {{ completeness }}% complete
</div>
```

### 4. Add Profile View for Other Users
```php
Route::get('/profile/{user}', [ProfileController::class, 'show']);
```

## 📚 References

- [Laravel Relationships](https://laravel.com/docs/eloquent-relationships)
- [Inertia.js Forms](https://inertiajs.com/forms)
- [Vue 3 Composition API](https://vuejs.org/guide/extras/composition-api-faq.html)

---

**Status**: ✅ READY FOR USE  
**Route**: `/profile`  
**Layout**: AppLocalLayout  
**Access**: All authenticated users
