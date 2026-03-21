import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { CheckCircle2, UserPlus, Users } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Following({ followingUsers, suggestedUsers, auth }) {
    const { post, processing } = useForm();

    const handleFollow = (userId) => {
        post(`/users/${userId}/follow`, {
            preserveScroll: true,
        });
    };

    return (
        <AppLayout>
            <Head title="Following - AmazamaHub" />

            <div className="max-w-4xl mx-auto py-8 px-4 pb-24 md:pb-8">
                {followingUsers.length > 0 ? (
                    <div className="space-y-8">
                        <div className="flex items-center space-x-3 mb-6">
                            <Users className="text-primary" size={28} />
                            <h2 className="text-2xl font-black italic">Accounts you follow</h2>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {followingUsers.map((user) => (
                                <div key={user.id} className="bg-gray-900/40 border border-gray-800 p-4 rounded-2xl flex items-center justify-between group hover:border-gray-700 transition">
                                    <Link href={`/profile/${user.username}`} className="flex items-center space-x-4">
                                        <div className="w-14 h-14 rounded-full overflow-hidden bg-gray-800 border-2 border-primary/20">
                                            {user.avatar ? (
                                                <img src={user.avatar} className="w-full h-full object-cover" alt={user.username} />
                                            ) : (
                                                <div className="w-full h-full flex items-center justify-center text-xl font-bold">
                                                    {user.name[0]}
                                                </div>
                                            )}
                                        </div>
                                        <div>
                                            <div className="flex items-center space-x-1">
                                                <p className="font-black truncate max-w-[120px]">{user.username}</p>
                                                <CheckCircle2 className="text-blue-400 fill-blue-400/20" size={14} />
                                            </div>
                                            <p className="text-xs text-gray-500 font-medium">{user.name}</p>
                                        </div>
                                    </Link>
                                    <button
                                        onClick={() => handleFollow(user.id)}
                                        className="bg-gray-800 text-white px-6 py-2 rounded-md font-bold text-sm hover:bg-gray-700 transition active:scale-95"
                                    >
                                        Following
                                    </button>
                                </div>
                            ))}
                        </div>
                    </div>
                ) : (
                    <div className="text-center py-20 bg-gray-900/20 rounded-3xl border border-dashed border-gray-800 mb-10">
                        <div className="bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <Users size={40} className="text-gray-500" />
                        </div>
                        <h3 className="text-xl font-black italic mb-2">Build your community</h3>
                        <p className="text-gray-500 max-w-sm mx-auto text-sm font-medium">Follow accounts to see their latest videos here and stay connected.</p>
                    </div>
                )}

                {/* Suggested Section */}
                <div className="mt-16">
                    <div className="flex items-center justify-between mb-8">
                        <div className="flex items-center space-x-3">
                            <UserPlus className="text-primary" size={28} />
                            <h2 className="text-2xl font-black italic text-white/90">Suggested for you</h2>
                        </div>
                        <button className="text-primary text-sm font-black hover:underline">See all</button>
                    </div>

                    <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        {suggestedUsers.map((user) => (
                            <motion.div
                                key={user.id}
                                whileHover={{ y: -5 }}
                                className="bg-gray-900/60 border border-gray-800/50 p-6 rounded-3xl text-center flex flex-col items-center space-y-4 hover:border-primary/30 transition shadow-xl"
                            >
                                <div className="w-20 h-20 rounded-full overflow-hidden bg-gray-800 border-2 border-gray-800 group-hover:border-primary/50 transition duration-500 shadow-lg">
                                    {user.avatar ? (
                                        <img src={user.avatar} className="w-full h-full object-cover" alt={user.username} />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-3xl font-black text-gray-600 bg-gray-800 italic">
                                            {user.name[0]}
                                        </div>
                                    )}
                                </div>
                                <div className="space-y-1">
                                    <div className="flex items-center justify-center space-x-1">
                                        <p className="font-black text-sm truncate max-w-[100px] italic">{user.name}</p>
                                        <CheckCircle2 className="text-blue-400 fill-blue-400/20" size={14} />
                                    </div>
                                    <p className="text-[10px] text-gray-500 font-black uppercase tracking-widest">@{user.username}</p>
                                </div>
                                <button
                                    onClick={() => handleFollow(user.id)}
                                    disabled={processing}
                                    className="w-full bg-primary text-black font-black py-2.5 rounded-xl text-xs hover:scale-105 active:scale-95 transition shadow-lg shadow-primary/10"
                                >
                                    Follow
                                </button>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
