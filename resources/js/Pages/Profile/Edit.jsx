import React, { useState } from 'react';
import AppLayout from '../../Components/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { ChevronLeft, Camera, User, AtSign, FileText, CheckCircle2 } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Edit({ auth }) {
    const { data, setData, post, processing, errors } = useForm({
        name: auth?.user?.name || '',
        username: auth?.user?.username || '',
        bio: auth?.user?.bio || '',
        avatar: null,
    });

    const [preview, setPreview] = useState(auth?.user?.avatar || null);

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('avatar', file);
            setPreview(URL.createObjectURL(file));
        }
    };

    const submit = (e) => {
        e.preventDefault();
        // Since we are uploading a file, we use a POST request (Laravel handles it as an update if we spoof it or use a dedicated route)
        post('/profile/update');
    };

    return (
        <AppLayout>
            <Head title="Edit profile" />

            <div className="p-6 md:p-10 max-w-3xl mx-auto w-full pb-24 md:pb-6">
                <div className="flex items-center space-x-4 mb-10">
                    <Link href="/profile" className="p-2 hover:bg-gray-800 rounded-full transition">
                        <ChevronLeft size={24} />
                    </Link>
                    <h1 className="text-2xl font-black italic">Edit profile</h1>
                </div>

                <form onSubmit={submit} className="space-y-10">
                    {/* Avatar Upload */}
                    <div className="flex flex-col items-center space-y-4">
                        <div className="relative group cursor-pointer">
                            <div className="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-900 bg-gray-800 flex items-center justify-center text-4xl font-bold relative">
                                {preview ? (
                                    <img src={preview} className="w-full h-full object-cover" alt="avatar" />
                                ) : (
                                    <span>{data.name[0]?.toUpperCase() || 'U'}</span>
                                )}
                                <div className="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                    <Camera className="text-white" size={32} />
                                </div>
                            </div>
                            <input
                                type="file"
                                className="absolute inset-0 opacity-0 cursor-pointer"
                                onChange={handleImageChange}
                                accept="image/*"
                            />
                        </div>
                        <p className="text-xs font-bold text-gray-500 uppercase tracking-widest">Change photo</p>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {/* Name */}
                        <div className="space-y-2">
                            <label className="text-sm font-bold text-gray-400 pl-1 uppercase">Name</label>
                            <div className="relative">
                                <User className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" size={18} />
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className="w-full bg-gray-900 border border-white/5 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary outline-none transition"
                                    placeholder="Enter your name"
                                    required
                                />
                            </div>
                            {errors.name && <p className="text-red-500 text-xs">{errors.name}</p>}
                        </div>

                        {/* Username */}
                        <div className="space-y-2">
                            <label className="text-sm font-bold text-gray-400 pl-1 uppercase">Username</label>
                            <div className="relative">
                                <AtSign className="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500" size={18} />
                                <input
                                    type="text"
                                    value={data.username}
                                    onChange={(e) => setData('username', e.target.value)}
                                    className="w-full bg-gray-900 border border-white/5 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary outline-none transition"
                                    placeholder="Enter username"
                                    required
                                />
                            </div>
                            {errors.username && <p className="text-red-500 text-xs">{errors.username}</p>}
                        </div>
                    </div>

                    {/* Bio */}
                    <div className="space-y-2">
                        <label className="text-sm font-bold text-gray-400 pl-1 uppercase">Bio</label>
                        <div className="relative">
                            <FileText className="absolute left-4 top-5 text-gray-500" size={18} />
                            <textarea
                                value={data.bio}
                                onChange={(e) => setData('bio', e.target.value)}
                                className="w-full bg-gray-900 border border-white/5 rounded-2xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-primary outline-none transition min-h-[120px] resize-none"
                                placeholder="Tell the world about yourself..."
                            ></textarea>
                        </div>
                        <div className="flex justify-end pr-2 text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                            {data.bio.length} / 80
                        </div>
                    </div>

                    <div className="flex space-x-4 pt-6">
                        <Link
                            href="/profile"
                            className="flex-1 bg-gray-800 text-white font-bold py-4 rounded-2xl text-center hover:bg-gray-700 transition"
                        >
                            Cancel
                        </Link>
                        <button
                            type="submit"
                            disabled={processing}
                            className="flex-1 bg-primary text-black font-black py-4 rounded-2xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition disabled:opacity-50"
                        >
                            {processing ? 'Saving...' : 'Save Changes'}
                        </button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
