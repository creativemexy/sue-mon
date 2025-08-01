"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import AdminDashboard from "@/pages/AdminDashboard";

export default function AdminPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <AdminDashboard />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 