import React, { useState } from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, useForm } from '@inertiajs/react';
import { Upload as UploadIcon, Video, Music, CheckCircle2, Loader2, AlertCircle } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';

export default function Upload() {
    const categories = ['Trending', 'Comedy', 'Education', 'Gaming', 'Music', 'Vlogs'];
    const { data, setData, post, processing, errors, reset, progress } = useForm({
        video: null,
        caption: '',
        category: 'Trending',
    });

    const [preview, setPreview] = useState(null);
    const [success, setSuccess] = useState(false);
    const [fileError, setFileError] = useState(null);

    const handleVideoChange = (e) => {
        const file = e.target.files[0];
        setFileError(null);
        if (file) {
            const maxSize = 40 * 1024 * 1024; // 40MB
            if (file.size > maxSize) {
                setFileError("Video is too large! Maximum allowed size is 40MB.");
                setData('video', null);
                setPreview(null);
                return;
            }
            setData('video', file);
            setPreview(URL.createObjectURL(file));
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post('/videos', {
            onSuccess: () => {
                setSuccess(true);
                reset();
                setPreview(null);
                setTimeout(() => setSuccess(false), 3000);
            },
        });
    };

    return (
        <AppLayout>
            <Head title="Upload Video" />
            <div className="p-6 max-w-5xl mx-auto h-full flex flex-col items-center justify-center pb-24 md:pb-6">
                <AnimatePresence>
                    {success && (
                        <motion.div
                            initial={{ opacity: 0, y: -20 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0 }}
                            className="bg-green-500 text-black font-bold px-6 py-3 rounded-full mb-8 flex items-center space-x-2 shadow-lg"
                        >
                            <CheckCircle2 size={20} />
                            <span>Video uploaded successfully!</span>
                        </motion.div>
                    )}
                    {fileError && (
                        <motion.div
                            initial={{ opacity: 0, y: -20 }}
                            animate={{ opacity: 1, y: 0 }}
                            exit={{ opacity: 0 }}
                            className="bg-red-500 text-white font-bold px-6 py-3 rounded-full mb-8 flex items-center space-x-2 shadow-lg"
                        >
                            <AlertCircle size={20} />
                            <span>{fileError}</span>
                        </motion.div>
                    )}
                </AnimatePresence>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-10 w-full max-w-4xl bg-gray-900/40 p-10 rounded-3xl border border-white/10 backdrop-blur-sm">
                    {/* Left: Upload Area */}
                    <div className="lg:col-span-1">
                        <div className="relative aspect-[9/16] bg-black border-2 border-dashed border-gray-700 rounded-2xl overflow-hidden group hover:border-primary transition">
                            {preview ? (
                                <video src={preview} className="w-full h-full object-cover" controls />
                            ) : (
                                <div className="absolute inset-0 flex flex-col items-center justify-center text-center p-4 space-y-4">
                                    <div className="bg-gray-800 rounded-full p-4 group-hover:bg-primary/20 transition">
                                        <UploadIcon className="w-10 h-10 text-gray-500 group-hover:text-primary transition" />
                                    </div>
                                    <div className="space-y-1">
                                        <p className="font-bold">Select video</p>
                                        <p className="text-xs text-gray-500">MP4 or WebM (Max 40MB)</p>
                                    </div>
                                    <button className="bg-primary text-black text-xs font-black px-4 py-2 rounded-md">
                                        Select file
                                    </button>
                                </div>
                            )}
                            <input
                                type="file"
                                className="absolute inset-0 opacity-0 cursor-pointer"
                                onChange={handleVideoChange}
                                accept="video/*"
                            />
                        </div>
                    </div>

                    {/* Right: Form Info */}
                    <div className="lg:col-span-2 space-y-8">
                        <div className="space-y-2">
                            <label className="text-sm font-bold text-gray-400 uppercase tracking-widest pl-1">Caption</label>
                            <textarea
                                value={data.caption}
                                onChange={e => setData('caption', e.target.value)}
                                className="w-full bg-black/40 border border-white/10 rounded-xl py-4 px-4 focus:ring-2 focus:ring-primary outline-none transition min-h-[100px] resize-none"
                                placeholder="Add a catchy caption..."
                            />
                            <p className="text-right text-[10px] text-gray-500 font-bold uppercase">{data.caption.length} / 255</p>
                        </div>

                        {progress && (
                            <div className="w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                                <motion.div 
                                    initial={{ width: 0 }}
                                    animate={{ width: `${progress.percentage}%` }}
                                    className="bg-primary h-full"
                                />
                            </div>
                        )}

                        <div className="space-y-4">
                            <label className="text-sm font-bold text-gray-400 uppercase tracking-widest pl-1">Category</label>
                            <div className="flex flex-wrap gap-2">
                                {categories.map(cat => (
                                    <button
                                        key={cat}
                                        type="button"
                                        onClick={() => setData('category', cat)}
                                        className={`px-4 py-2 rounded-full text-xs font-black italic transition transform active:scale-95 ${data.category === cat ? 'bg-primary text-black' : 'bg-gray-800 text-gray-400 hover:bg-gray-700'}`}
                                    >
                                        {cat}
                                    </button>
                                ))}
                            </div>
                        </div>

                        <div className="space-y-4">
                            <div className="flex items-center space-x-3 text-sm text-gray-400 font-medium">
                                <Video size={18} className="text-primary" />
                                <span>Max File Size: <b>40 MB</b></span>
                            </div>
                            <div className="flex items-center space-x-3 text-sm text-gray-400 font-medium">
                                <Music size={18} />
                                <span>Original sound will be used</span>
                            </div>
                        </div>

                        <button
                            onClick={submit}
                            disabled={processing || !data.video}
                            className="w-full bg-primary text-black font-black py-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition disabled:opacity-50 flex items-center justify-center space-x-2"
                        >
                            {processing ? (
                                <>
                                    <Loader2 className="animate-spin" size={20} />
                                    <span>Post video...</span>
                                </>
                            ) : (
                                <span>Post video</span>
                            )}
                        </button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
