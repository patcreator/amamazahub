import React, { useState } from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link, router } from '@inertiajs/react';
import { Edit2, Grid, Lock, Heart, Share2, BadgeCheck, Plus, Check } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';
import axios from 'axios';

export default function Profile({ profileUser, videos, stats, isFollowing: initialFollowing, isOwnProfile }) {
    const [isFollowing, setIsFollowing] = useState(initialFollowing);
    const [localStats, setLocalStats] = useState(stats);

    const toggleFollow = async () => {
        if (isOwnProfile) return;
        try {
            const response = await axios.post(`/users/${profileUser.id}/follow`);
            setIsFollowing(response.data.following);
            setLocalStats(prev => ({
                ...prev,
                followers: response.data.following ? prev.followers + 1 : prev.followers - 1
            }));
        } catch (error) {
            console.error('Error toggling follow', error);
        }
    };

    return (
        <AppLayout>
            <Head title={`${profileUser.name} (@${profileUser.username}) | AmazamaHub`} />
            <div className="p-6 md:p-10 max-w-5xl mx-auto w-full pb-24 md:pb-6">
                {/* Header Profile Section */}
                <div className="flex flex-col md:flex-row items-start md:items-center justify-between space-y-6 md:space-y-0">
                    <div className="flex items-center space-x-6">
                        <motion.div 
                            initial={{ scale: 0.8, opacity: 0 }}
                            animate={{ scale: 1, opacity: 1 }}
                            className="w-24 md:w-32 h-24 md:h-32 rounded-full bg-gradient-to-br from-gray-950 to-primary border-4 border-gray-900 overflow-hidden flex items-center justify-center text-4xl font-black relative shadow-2xl"
                        >
                            {profileUser.avatar ? (
                                <img src={profileUser.avatar} className="w-full h-full object-cover" alt="avatar" />
                            ) : (
                                <span className="text-white opacity-40">{profileUser.name[0]?.toUpperCase()}</span>
                            )}
                        </motion.div>
                        <div className="space-y-4">
                            <div>
                                <div className="flex items-center space-x-2">
                                    <h1 className="text-2xl md:text-3xl font-black italic tracking-tighter text-white">{profileUser.name}</h1>
                                    <BadgeCheck className="text-blue-400 fill-blue-400/20" size={22} />
                                </div>
                                <p className="text-md font-black italic text-gray-400 tracking-tight">@{profileUser.username}</p>
                            </div>
                            
                            <div className="flex items-center space-x-3">
                                {isOwnProfile ? (
                                    <Link href="/profile/edit" className="flex items-center space-x-2 bg-gray-900 hover:bg-gray-800 px-8 py-2.5 rounded-xl font-black italic text-sm border border-white/5 transition transform active:scale-95 shadow-2xl">
                                        <Edit2 size={16} />
                                        <span>Edit profile</span>
                                    </Link>
                                ) : (
                                    <div className="flex items-center space-x-2">
                                        <button 
                                            onClick={toggleFollow}
                                            className={`flex items-center justify-center space-x-2 px-10 py-2.5 rounded-xl font-black italic text-sm transition transform active:scale-95 shadow-2xl border ${isFollowing ? 'bg-gray-900 text-white border-white/10 hover:bg-gray-800' : 'bg-primary text-black border-primary/20 hover:brightness-110'}`}
                                        >
                                            {isFollowing ? (
                                                <>
                                                    <Check size={18} strokeWidth={3} />
                                                    <span>Following</span>
                                                </>
                                            ) : (
                                                <>
                                                    <Plus size={18} strokeWidth={3} />
                                                    <span>Follow</span>
                                                </>
                                            )}
                                        </button>
                                        <Link 
                                            href="/messages" 
                                            className="flex items-center justify-center space-x-2 px-8 py-2.5 rounded-xl font-black italic text-sm bg-gray-900 text-white border border-white/5 hover:bg-gray-800 transition transform active:scale-95 shadow-2xl"
                                        >
                                            <MessageSquare size={18} />
                                            <span>Message</span>
                                        </Link>
                                    </div>
                                )}
                                <div className="p-2.5 bg-gray-900 rounded-xl border border-white/5 hover:bg-gray-800 transition cursor-pointer">
                                    <Share2 size={18} className="text-gray-400" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Stats */}
                <div className="flex space-x-10 mt-8 border-b border-gray-900/50 pb-8">
                    <div className="flex items-center space-x-2 group cursor-pointer">
                        <span className="font-black text-2xl italic tracking-tighter text-white group-hover:text-primary transition">{localStats.following}</span>
                        <span className="text-gray-500 text-xs font-black uppercase tracking-widest">Following</span>
                    </div>
                    <div className="flex items-center space-x-2 group cursor-pointer">
                        <span className="font-black text-2xl italic tracking-tighter text-white group-hover:text-primary transition">{localStats.followers}</span>
                        <span className="text-gray-500 text-xs font-black uppercase tracking-widest">Followers</span>
                    </div>
                    <div className="flex items-center space-x-2 group cursor-pointer">
                        <span className="font-black text-2xl italic tracking-tighter text-white group-hover:text-primary transition">
                            {Intl.NumberFormat('en-US', { notation: 'compact' }).format(localStats.likes)}
                        </span>
                        <span className="text-gray-500 text-xs font-black uppercase tracking-widest">Likes</span>
                    </div>
                </div>

                {/* Bio */}
                <div className="py-8">
                    <p className="text-sm font-medium text-gray-300 leading-relaxed max-w-xl">
                        {profileUser.bio || (isOwnProfile ? 'Click Edit Profile to add a bio!' : 'No bio yet.')}
                    </p>
                </div>

                {/* Tabs */}
                <div className="flex border-b border-white/5 relative mb-6">
                    <button className="px-12 py-4 font-black italic text-xs uppercase tracking-widest text-white border-b-2 border-white flex items-center space-x-3 transition">
                        <Grid size={18} className="text-primary" />
                        <span>Videos</span>
                    </button>
                    <button className="px-12 py-4 font-black italic text-xs uppercase tracking-widest text-gray-600 hover:text-white flex items-center space-x-3 transition">
                        <Lock size={18} />
                        <span>Liked</span>
                    </button>
                </div>

                {/* Videos Grid */}
                {videos.length === 0 ? (
                    <div className="flex flex-col items-center justify-center py-24 text-gray-700 bg-gray-950/50 rounded-[40px] border border-white/5">
                        <Grid size={64} className="mb-4 opacity-10" />
                        <h3 className="text-lg font-black italic uppercase tracking-widest">No videos yet</h3>
                        <p className="text-sm mt-1">Start sharing your Rwandan vibes! 🇷🇼</p>
                    </div>
                ) : (
                    <div className="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-1.5 px-0.5">
                        {videos.map((v) => (
                            <Link 
                                href="/video-detail" 
                                key={v.id} 
                                className="aspect-[9/16] bg-gray-950 rounded-lg overflow-hidden relative group cursor-pointer border border-white/5 hover:border-white/20 transition-all duration-300"
                            >
                                <img src={v.thumbnail_url} className="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-110 transition duration-700" alt="video" />
                                <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-60 group-hover:opacity-90 transition duration-300 flex items-end p-3">
                                    <div className="flex items-center space-x-1.5 text-white text-xs font-black italic tracking-tighter">
                                        <Heart size={14} className="text-primary fill-primary" />
                                        <span>{Intl.NumberFormat('en-US', { notation: 'compact' }).format(v.likes_count)}</span>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
