import React, { useState } from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link, router } from '@inertiajs/react';
import { Search, TrendingUp, Music2, Play } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Explore({ videos, currentCategory, categories }) {
    const [searchTerm, setSearchTerm] = useState('');

    const handleCategoryChange = (cat) => {
        router.get('/explore', { category: cat }, { preserveState: true });
    };

    const handleSearch = (e) => {
        if (e.key === 'Enter') {
            router.get('/explore', { search: searchTerm }, { preserveState: true });
        }
    };

    return (
        <AppLayout>
            <Head title={`Explore ${currentCategory} - AmazamaHub`} />
            <div className="p-6 max-w-6xl mx-auto space-y-8 pb-20 md:pb-6">
                {/* Search Bar */}
                <div className="bg-gray-900/50 rounded-2xl p-5 border border-gray-800 flex items-center space-x-4 shadow-2xl focus-within:border-primary transition duration-300">
                    <Search className="text-gray-500" size={24} />
                    <input
                        type="text"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        onKeyDown={handleSearch}
                        placeholder="Search for amazing creators and videos..."
                        className="bg-transparent border-none focus:ring-0 w-full text-lg font-medium placeholder-gray-600"
                    />
                </div>

                {/* Categories */}
                <div className="flex overflow-x-auto space-x-3 no-scrollbar scroll-smooth pb-2">
                    {categories.map(cat => (
                        <button 
                            key={cat} 
                            onClick={() => handleCategoryChange(cat)}
                            className={`px-8 py-2.5 rounded-full font-black italic text-sm tracking-tight transition transform active:scale-95 ${currentCategory === cat ? 'bg-white text-black shadow-xl' : 'bg-gray-900/60 text-gray-400 hover:bg-gray-800 border border-gray-800'}`}
                        >
                            {cat}
                        </button>
                    ))}
                </div>

                {/* Content Grid */}
                <div className="space-y-6">
                    <div className="flex items-center justify-between px-2">
                        <h2 className="text-2xl font-black italic tracking-tighter flex items-center space-x-3 uppercase">
                            <TrendingUp className="text-primary" size={28} />
                            <span>{currentCategory} Feed</span>
                        </h2>
                        <span className="text-xs text-gray-500 font-bold uppercase tracking-widest">{videos.total} results</span>
                    </div>

                    <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        {videos.data.map((video, i) => (
                            <motion.div 
                                key={video.id}
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: i * 0.05 }}
                                className="aspect-[9/16] bg-gray-900 rounded-[32px] overflow-hidden relative group cursor-pointer transition transform hover:scale-[1.02] active:scale-95 shadow-lg border border-gray-800"
                            >
                                <Link href={`/v/${video.id}`}>
                                    <img 
                                        src={video.thumbnail_url} 
                                        className="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-700 group-hover:scale-110" 
                                        alt={video.caption} 
                                    />
                                    <div className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black via-black/20 to-transparent p-4 pb-6 border-b-2 border-primary/0 group-hover:border-primary transition-all duration-300">
                                        <div className="space-y-2">
                                            <p className="text-white font-black italic text-xs leading-tight line-clamp-2 pr-2">
                                                {video.caption}
                                            </p>
                                            <div className="flex items-center justify-between">
                                                <div className="flex items-center space-x-1.5 text-[10px] font-black italic tracking-tight text-white/70">
                                                    <Music2 size={12} className="text-primary" />
                                                    <span className="truncate max-w-[80px]">@{video.user.username}</span>
                                                </div>
                                                <div className="flex items-center space-x-1 text-[10px] font-black text-white bg-black/40 px-2 py-0.5 rounded-full">
                                                    <Play size={10} fill="currentColor" />
                                                    <span>{Intl.NumberFormat('en-US', { notation: 'compact' }).format(video.likes_count)}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            </motion.div>
                        ))}
                    </div>

                    {/* Pagination Placeholder */}
                    {videos.data.length === 0 && (
                        <div className="text-center py-20">
                             <TrendingUp size={48} className="mx-auto text-gray-800 mb-4 opacity-20" />
                             <p className="text-gray-500 font-bold italic tracking-tighter">No videos found in this category yet.</p>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
