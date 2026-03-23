import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import axios from 'axios';
import '../../css/dashboard.css';

export default function Dashboard() {
    const [metrics, setMetrics] = useState(null);
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get('/api/metrics')
            .then(res => {
                setMetrics(res.data.metrics);
                setPosts(res.data.recent_posts);
            })
            .catch(err => console.error("Error fetching metrics", err))
            .finally(() => setLoading(false));
    }, []);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Social Media Analytics
                </h2>
            }
        >
            <Head title="Analytics Dashboard" />

            <div className="dashboard-container">
                <div className="dashboard-header">
                    <h1>Real-Time Reddit Engagement</h1>
                    <p>Monitoring top posts from r/webdev to keep your pulse on the community.</p>
                </div>

                {loading ? (
                    <div className="loading-spinner">
                        <div className="spinner"></div>
                        <p>Aggregating data via REST API...</p>
                    </div>
                ) : (
                    <>
                        <div className="metrics-grid">
                            <div className="metric-card">
                                <h3>Total Likes</h3>
                                <p className="metric-value">{metrics?.total_likes?.toLocaleString()}</p>
                                <div className="metric-icon">👍</div>
                            </div>
                            <div className="metric-card">
                                <h3>Total Comments</h3>
                                <p className="metric-value">{metrics?.total_comments?.toLocaleString()}</p>
                                <div className="metric-icon">💬</div>
                            </div>
                            <div className="metric-card">
                                <h3>Avg. Engagement</h3>
                                <p className="metric-value">{metrics?.avg_engagement}</p>
                                <div className="metric-icon">📈</div>
                            </div>
                            <div className="metric-card">
                                <h3>Posts Tracked</h3>
                                <p className="metric-value">{metrics?.total_posts}</p>
                                <div className="metric-icon">📌</div>
                            </div>
                        </div>

                        <div className="posts-section">
                            <h2>Top Performing Posts</h2>
                            <div className="posts-list">
                                {posts.map(post => (
                                    <a key={post.id} href={post.permalink} target="_blank" rel="noreferrer" className="post-card">
                                        {post.thumbnail && !['self', 'default', ''].includes(post.thumbnail) && (
                                            <div className="post-thumb">
                                                <img src={post.thumbnail} alt={post.title} />
                                            </div>
                                        )}
                                        <div className="post-content">
                                            <h4>{post.title}</h4>
                                            <div className="post-meta">
                                                <span>By u/{post.author}</span>
                                                <span>•</span>
                                                <span className="post-score">↑ {post.score}</span>
                                                <span className="post-comments">💬 {post.num_comments}</span>
                                            </div>
                                        </div>
                                    </a>
                                ))}
                            </div>
                        </div>
                    </>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
